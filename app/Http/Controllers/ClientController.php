<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;
// use App\Traits\TracksUserActions;
use Illuminate\Support\Facades\DB;
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

    // Données pour le graphique d'évolution du nombre de clients
    $clientGrowthData = Client::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count');
    $clientGrowthLabels = Client::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('month');

    // Données pour le graphique des top 5 conventions collectives
    $topConventions = ConventionCollective::withCount('clients')
        ->orderByDesc('clients_count')
        ->take(5)
        ->get();
    $topConventionsData = $topConventions->pluck('clients_count');
    $topConventionsLabels = $topConventions->pluck('name');

    // Données pour le graphique de répartition des clients par gestionnaire principal
     $clientsByManager = User::whereHas('clientsAsManager')
     ->withCount('clientsAsManager')
     ->orderByDesc('clients_as_manager_count')
     ->take(10)
     ->get();
    $clientsByManagerData = $clientsByManager->pluck('clients_as_manager_count');
    $clientsByManagerLabels = $clientsByManager->pluck('name');

    return view('clients.index', compact(
        'clients',
        'clientGrowthData',
        'clientGrowthLabels',
        'topConventionsData',
        'topConventionsLabels',
        'clientsByManagerData',
        'clientsByManagerLabels'
    ));
}
    public function create()
    {
        $users = User::all();
        $conventionCollectives = ConventionCollective::all();
        $portfolioClients = Client::where('is_portfolio', true)->get();
        return view('clients.create', compact('users', 'conventionCollectives', 'portfolioClients'));
    }

    public function edit(Client $client)
    {
        $users = User::all();
        $conventionCollectives = ConventionCollective::all();
        $portfolioClients = Client::where('is_portfolio', true)->where('id', '!=', $client->id)->get();
        return view('clients.edit', compact('client', 'users', 'conventionCollectives', 'portfolioClients'));
    }

    public function store(StoreClientRequest $request)
    {
        $validatedData = $request->validated();
        
        \Log::info('Validated data:', $validatedData);
    
        $client = Client::create($validatedData);
    
        \Log::info('Created client:', $client->toArray());
    
        return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
    }
    
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validatedData = $request->validated();
        
        \Log::info('Validated data:', $validatedData);
    
        $client->update($validatedData);
    
        \Log::info('Updated client:', $client->fresh()->toArray());
    
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
    
        DB::transaction(function () use ($client) {
            // Supprimer les enregistrements associés dans gestionnaire_client
            $client->gestionnaires()->detach();
    
            // Supprimer le client
            $client->delete();
        });
    
        // $this->logAction('delete_client', "Suppression du client #{$client->id}");
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
    }
}
