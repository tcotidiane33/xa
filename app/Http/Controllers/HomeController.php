<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\TraitementPaie;
use App\Models\PeriodePaie;
use App\Models\Ticket;

class HomeController extends Controller
{
    public function index()
    {
        $clientCount = Client::count();
        $traitementCount = TraitementPaie::count();
        $periodeCount = PeriodePaie::count();
        $ticketCount = Ticket::count();

        $recentTraitements = TraitementPaie::with('client')->latest()->take(5)->get();
        $recentTickets = Ticket::with('createur')->latest()->take(5)->get();

        return view('dashboard', compact(
            'clientCount',
            'traitementCount',
            'periodeCount',
            'ticketCount',
            'recentTraitements',
            'recentTickets'
        ));
    }
}
