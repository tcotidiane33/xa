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
        // Créer les rôles
        $admin = Role::create(['name' => 'admin']);
        $gestionnaire = Role::create(['name' => 'gestionnaire']);
        $responsable = Role::create(['name' => 'responsable']);
        $superviseur = Role::create(['name' => 'superviseur']);

        // Créer les permissions
        $viewClient = Permission::create(['name' => 'view clients']);
        $createClient = Permission::create(['name' => 'create clients']);
        $editClient = Permission::create(['name' => 'edit clients']);
        $deleteClient = Permission::create(['name' => 'delete clients']);

        // Créer les permissions
        $viewGestionnaire = Permission::create(['name' => 'view gestionnaires']);
        $createGestionnaire = Permission::create(['name' => 'create gestionnaires']);
        $editGestionnaire = Permission::create(['name' => 'edit gestionnaires']);
        $deleteGestionnaire = Permission::create(['name' => 'delete gestionnaires']);
        
        // Créer les permissions
        $viewResponsable = Permission::create(['name' => 'view responsables']);
        $createResponsable = Permission::create(['name' => 'create responsables']);
        $editResponsable = Permission::create(['name' => 'edit responsables']);
        $deleteResponsable = Permission::create(['name' => 'delete responsables']);
        
        // Créer les permissions
        $viewSuperviseur = Permission::create(['name' => 'view superviseurs']);
        $createSuperviseur = Permission::create(['name' => 'create superviseurs']);
        $editSuperviseur = Permission::create(['name' => 'edit superviseurs']);
        $deleteSuperviseur = Permission::create(['name' => 'delete superviseurs']);
        
        // Créer les permissions
        $viewTraitementPaie = Permission::create(['name' => 'view traitements-paie']);
        $createTraitementPaie = Permission::create(['name' => 'create traitements-paie']);
        $editTraitementPaie = Permission::create(['name' => 'edit traitements-paie']);
        $deleteTraitementPaie = Permission::create(['name' => 'delete traitements-paie']);

        // Créer les permissions
        $viewPeriodePaie = Permission::create(['name' => 'view periodes-paie']);
        $createPeriodePaie = Permission::create(['name' => 'create periodes-paie']);
        $editPeriodePaie = Permission::create(['name' => 'edit periodes-paie']);
        $deletePeriodePaie = Permission::create(['name' => 'delete periodes-paie']);

        // Attribuer les permissions aux rôles
        $admin->givePermissionTo(Permission::all());
        $gestionnaire->givePermissionTo([$viewClient, $createClient, $editClient]);
        $responsable->givePermissionTo([$viewClient, $editClient, $viewPeriodePaie, $createTraitementPaie, $viewTraitementPaie, $editPeriodePaie, $editTraitementPaie, $createPeriodePaie]);
        $superviseur->givePermissionTo([$viewClient, $viewPeriodePaie, $viewTraitementPaie, $viewResponsable, $viewGestionnaire]);
    }
}
