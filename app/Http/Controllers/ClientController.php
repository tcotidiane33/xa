<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ClientHistory;
use App\Exports\ClientsExport;
use App\Services\ClientService;
use Illuminate\Support\Facades\DB;
use App\Models\ConventionCollective;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\ClientManagerChangeMail;
use App\Notifications\RelationUpdated;
use App\Mail\ClientAcknowledgementMail;

use App\Notifications\NewClientCreated;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    public function index(Request $request)
    {
        $clients = $this->clientService->getClients($request);
        $clientGrowthData = $this->clientService->getClientGrowthData();
        $topConventionsData = $this->clientService->getTopConventionsData();
        $clientsByManagerData = $this->clientService->getClientsByManagerData();

        return view('clients.index', compact(
            'clients',
            'clientGrowthData',
            'topConventionsData',
            'clientsByManagerData'
        ));
    }
    public function storePartial(Request $request)
    {
        $result = $this->clientService->storePartial($request);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'nextStep' => $result['nextStep'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'errors' => $result['errors'] ?? [],
            ], 422);
        }
    }

    public function create()
    {
        $users = User::all();
        $conventionCollectives = ConventionCollective::all();
        $clients = Client::all();
        return view('clients.create', compact('users', 'conventionCollectives', 'clients'));
    }

    public function store(StoreClientRequest $request)
    {
        $result = $this->clientService->storeClient($request);

        if ($result['success']) {
            return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur lors de la création du client.');
        }
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $result = $this->clientService->updateClient($request, $id);

        if ($result['success']) {
            return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur lors de la mise à jour du client.');
        }
    }

    public function edit(Client $client)
    {
        $users = User::all();
        $conventionCollectives = ConventionCollective::all();
        $clients = Client::all();
        return view('clients.edit', compact('client', 'users', 'conventionCollectives', 'clients'));
    }

    public function show(Client $client)
    {
        $client->load(['responsablePaie', 'gestionnairePrincipal', 'conventionCollective', 'portfolioCabinet']);
        $events = $this->clientService->getClientEvents($client);

        return view('clients.show', compact('client', 'events'));
    }

    public function export()
    {
        return $this->clientService->exportClients();
    }

    public function destroy(Client $client)
    {
        $result = $this->clientService->deleteClient($client);

        if ($result['success']) {
            return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur lors de la suppression du client.');
        }
    }

    public function getInfo(Client $client)
    {
        return response()->json($this->clientService->getClientInfo($client));
    }

    public function transfer(Request $request)
    {
        $result = $this->clientService->transferClients($request);

        if ($result['success']) {
            return redirect()->route('admin.clients.index')->with('success', 'Clients transférés avec succès.');
        } else {
            return redirect()->back()->withErrors('Une erreur est survenue : ' . $result['message']);
        }
    }

    public function validateStep(Request $request, $step)
    {
        $result = $this->clientService->validateStep($request, $step);

        if ($result['success']) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['errors' => $result['errors']], 422);
        }
    }

    public function updatePartial(UpdateClientRequest $request, Client $client, $step)
    {
        $result = $this->clientService->updatePartial($request, $client, $step);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Données mises à jour avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur lors de la mise à jour du client.');
        }
    }

    public function updateRelation(Request $request, $userId)
    {
        $result = $this->clientService->updateRelation($request, $userId);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Notification envoyée avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur lors de l\'envoi de la notification.');
        }
    }

    public function attachGestionnaire(Request $request, Client $client)
    {
        $result = $this->clientService->attachGestionnaire($request, $client);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Gestionnaire ajouté avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur lors de l\'ajout du gestionnaire.');
        }
    }

    public function detachGestionnaire(Request $request, Client $client)
    {
        $result = $this->clientService->detachGestionnaire($request, $client);

        if ($result['success']) {
            return redirect()->back()->with('success', 'Gestionnaire retiré avec succès.');
        } else {
            return redirect()->back()->withErrors('Erreur lors du retrait du gestionnaire.');
        }
    }

}
