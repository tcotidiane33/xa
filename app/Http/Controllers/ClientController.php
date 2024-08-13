<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Traits\TracksUserActions;
use App\Notifications\NewClientCreated;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use TracksUserActions;

    public function index(Request $request)
    {
        $this->authorize('viewAny', Client::class);
        $clients = Client::with(['responsablePaie', 'gestionnairePrincipal'])
                         ->filter($request->only(['search', 'status']))
                         ->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function store(StoreClientRequest $request)
    {
        $this->authorize('create', Client::class);
        $client = Client::create($request->validated());
        $this->logAction('create_client', "Création du client #{$client->id}");
        Notification::send(User::role('admin')->get(), new NewClientCreated($client));
        return redirect()->route('clients.show', $client)->with('success', 'Client créé avec succès.');
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);
        $client->update($request->validated());
        $this->logAction('update_client', "Mise à jour du client #{$client->id}");
        return redirect()->route('clients.show', $client)->with('success', 'Client mis à jour avec succès.');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }


    /**
     * Store a newly created resource in storage.
     */
  
    /**
     * Display the specified resource.
     */
     public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }



    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
}
