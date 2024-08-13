<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('roles.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        try {
            $role = Role::findOrCreate($request->name);
            $permissions = $request->input('permissions', []);
            $role->syncPermissions($permissions);
            return redirect()->route('roles.index')->with('success', 'Rôle créé ou mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de la création du rôle : ' . $e->getMessage());
        }
    }
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        $role->name = $request->name;
        $role->save();

        // Synchronisez les permissions directement par leurs noms
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('roles.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rôle supprimé avec succès.');
    }

    public function createPermission()
    {
        return view('roles.create_permission');
    }

    public function storePermission(Request $request)
    {
        Permission::create(['name' => $request->name]);
        return redirect()->route('roles.index')->with('success', 'Permission créée avec succès.');
    }

    public function assignRole()
{
    $users = User::with('roles')->get();
    $roles = Role::all();
    return view('roles.assign_role', compact('users', 'roles'));
}

public function storeAssignRole(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'roles' => 'array',
        'roles.*' => 'exists:roles,id',
    ]);

    $user = User::findOrFail($request->user_id);
    $roles = Role::whereIn('id', $request->roles ?? [])->pluck('name');
    
    $user->syncRoles($roles);
    
    return redirect()->route('roles.assign')->with('success', 'Rôles assignés avec succès.');
}


    public function show(Role $role)
    {
        // return view('roles.show', compact('role'));
        abort(404);  // Ou rediriger vers une autre page

    }
}