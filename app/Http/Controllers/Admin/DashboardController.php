<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch total counts of roles, permissions, users, clients, etc.
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $totalUsers = User::count();
        $totalClients = Client::count();  // Assuming you have a Client model

        return view('admin.dashboard', compact('totalRoles', 'totalPermissions', 'totalUsers', 'totalClients'));
    }

    public function recentClients()
    {
        // Récupérer les 10 clients les plus récents
        $recentClients = Client::latest()->take(10)->get();

        // Retourner la vue avec les clients récents
        return view('admin.dashboard', compact('recentClients'));
    }
}
