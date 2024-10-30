<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions if they do not exist
        $permissions = ['manage forms', 'manage fields', 'manage actions'];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }

        // Create roles and assign created permissions

        // Admin (N)
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo($permissions);

        // Responsable (N-1)
        $responsable = Role::firstOrCreate(['name' => 'Responsable']);
        $responsable->givePermissionTo(['manage forms', 'manage fields']);

        // Gestionnaire (N-2)
        $gestionnaire = Role::firstOrCreate(['name' => 'Gestionnaire']);
        $gestionnaire->givePermissionTo(['manage forms']);
    }
}
