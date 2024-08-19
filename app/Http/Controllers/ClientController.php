<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;
// use App\Traits\TracksUserActions;
use App\Models\ConventionCollective;
use App\Notifications\NewClientCreated;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

class ClientController extends Controller
{
    // use TracksUserActions;

    public function index()
    {
        $clients = Client::with(['responsablePaie', 'gestionnairePrincipal', 'conventionCollective'])
            ->filter(request()->only(['search', 'status']))
            ->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $users = User::all();
        $conventionCollectives = ConventionCollective::all();
        return view('clients.create', compact('users', 'conventionCollectives'));
    }

    public function edit(Client $client)
    {
        $users = User::all();
        $conventionCollectives = ConventionCollective::all();
        return view('clients.edit', compact('client', 'users', 'conventionCollectives'));
    }

    //     public function store(StoreClientRequest $request)
//     {
//         $this->authorize('create', Client::class);
//         $client = Client::create($request->validated());
//         $this->logAction('create_client', "Création du client #{$client->id}");
//         // Notification::send(User::role('admin')->get(), new NewClientCreated($client));
//         return redirect()->route('clients.show', $client)->with('success', 'Client créé avec succès.');
//     }
//  public function update(UpdateClientRequest $request, Client $client)
//     {
//         $this->authorize('update', $client);
//         $client->update($request->validated());
//         $this->logAction('update_client', "Mise à jour du client #{$client->id}");
//         return redirect()->route('clients.show', $client)->with('success', 'Client mis à jour avec succès.');
//     }

    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());
        // $this->logAction('create_client', "Création du client #{$client->id}");
        // Notification::send(User::role('admin')->get(), new NewClientCreated($client))
        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        // $this->logAction('update_client', "Mise à jour du client #{$client->id}");
        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);
        $client->load(['responsablePaie', 'gestionnairePrincipal']);
        return view('clients.show', compact('client'));
    }



    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);
        $client->delete();
        $this->logAction('delete_client', "Suppression du client #{$client->id}");
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
}
