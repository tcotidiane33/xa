<?php
// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->roles()->sync($validated['roles']);

        return redirect()->route('users.show', $user)->with('success', 'Utilisateur créé avec succès.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (isset($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->roles()->sync($validated['roles']);

        return redirect()->route('users.show', $user)->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }


    public function manageClients(User $user)
    {
        $clients = Client::whereHas('gestionnaires', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->paginate(15);
        
        return view('users.manage_clients', compact('user', 'clients'));
    }

    public function attachClient(Request $request, User $user)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
        ]);

        $user->clients()->syncWithoutDetaching([$validated['client_id']]);

        return redirect()->route('users.manage_clients', $user)
            ->with('success', 'Client rattaché avec succès.');
    }

    public function detachClient(Request $request, User $user)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
        ]);

        $user->clients()->detach($validated['client_id']);

        return redirect()->route('users.manage_clients', $user)
            ->with('success', 'Client détaché avec succès.');
    }

    public function transferClients(Request $request, User $fromUser)
    {
        $validated = $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'client_ids' => 'required|array',
            'client_ids.*' => 'exists:clients,id',
        ]);

        $toUser = User::findOrFail($validated['to_user_id']);

        DB::transaction(function () use ($fromUser, $toUser, $validated) {
            foreach ($validated['client_ids'] as $clientId) {
                $client = Client::findOrFail($clientId);
                
                // Si c'est un client portefeuille, transférer tous ses sous-clients
                if ($client->is_portfolio) {
                    $subClients = $client->subClients;
                    foreach ($subClients as $subClient) {
                        $this->transferClientBetweenUsers($subClient, $fromUser, $toUser);
                    }
                }
                
                $this->transferClientBetweenUsers($client, $fromUser, $toUser);
            }
        });

        return redirect()->route('users.manage_clients', $fromUser)
            ->with('success', 'Clients transférés avec succès.');
    }

    private function transferClientBetweenUsers(Client $client, User $fromUser, User $toUser)
    {
        $client->gestionnaires()->detach($fromUser->id);
        $client->gestionnaires()->attach($toUser->id);
        
        if ($client->gestionnaire_principal_id == $fromUser->id) {
            $client->gestionnaire_principal_id = $toUser->id;
            $client->save();
        }
    }
}
