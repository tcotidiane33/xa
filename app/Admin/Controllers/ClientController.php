<?php

namespace App\Admin\Controllers;
// app/Admin/Controllers/ClientController.php
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\Client;

class ClientController extends AdminController
{
    protected function grid()
    {
        $grid = new Grid(new Client());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Nom'))->label();
        $grid->column('responsablePaie.name', __('Responsable Paie'))->label('info');
        $grid->column('gestionnairePrincipal.name', __('Gestionnaire Principal'))->label('danger');
        $grid->column('date_debut_prestation', __('Date de début'));
        $grid->column('created_at', __('Créé le'))->sortable();

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Client());

        $form->text('name', __('Nom'));
        $form->select('responsable_paie_id', __('Responsable Paie'))->options(User::pluck('name', 'id'));
        $form->select('gestionnaire_principal_id', __('Gestionnaire Principal'))->options(User::pluck('name', 'id'));
        $form->date('date_debut_prestation', __('Date de début'));
        $form->text('contact_paie', __('Contact Paie'));
        $form->text('contact_comptabilite', __('Contact Comptabilité'));

        return $form;
    }

    // ... autres méthodes ...
}

// Créez des contrôleurs similaires pour TraitementPaie, Ticket, User, etc.
