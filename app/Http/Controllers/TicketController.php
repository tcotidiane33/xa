<?php

// app/Http/Controllers/TicketController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Notifications\TicketCreated;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TicketNotification;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        // $ticket = new Ticket();
        $ticket = new Ticket($request->all());
        $ticket->user_id = Auth::id(); // Associe l'utilisateur au ticket

        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->status = $request->status;
        // $ticket->user_id = auth()->id(); // Lier le ticket à l'utilisateur authentifié
        if ($request->hasFile('screenshot')) {
            $path = $request->file('screenshot')->store('screenshots');
            // $ticket->image_path = $path;
            $ticket->screenshot = $path;
        }
        $ticket->save();
        // Ajout d'une notification avec les informations de l'utilisateur
        $ticket->notify(new TicketCreated($ticket, Auth::user()));

        return redirect()->route('tickets.index')->with('success', 'Ticket créé avec succès.');
    }

    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        return redirect()->route('tickets.index')->with('success', 'Ticket mis à jour avec succès.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket supprimé avec succès.');
    }
}
