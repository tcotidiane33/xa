<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Assurez-vous que l'utilisateur est authentifié pour toutes les méthodes du contrôleur
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Récupère l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifie si l'utilisateur est bien authentifié
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour voir vos notifications.');
        }

        // Récupère les notifications de l'utilisateur
        $notifications = $user->notifications;

        // Retourne la vue avec les notifications
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        // Récupère l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Vérifie si l'utilisateur est bien authentifié
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour marquer les notifications comme lues.');
        }

        // Récupère la notification spécifique
        $notification = $user->notifications()->find($id);

        // Vérifie si la notification existe et est associée à l'utilisateur
        if ($notification) {
            $notification->markAsRead();
        }

        // Retourne à la page précédente
        return redirect()->back();
    }
}
