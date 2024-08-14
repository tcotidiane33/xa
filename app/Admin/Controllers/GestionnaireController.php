<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Gestionnaire;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class GestionnaireController extends AdminController
{
    protected $title = 'Gestionnaires';

    protected function grid()
    {
        $grid = new Grid(new Gestionnaire());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('GID', __('GID'))->sortable()->label();
        $grid->column('user.name', __('Nom'))->sortable();
        $grid->column('user.email', __('Email'))->sortable();
        $grid->column('responsable.name', __('Responsable'))->label('warning');
        $grid->column('superviseur.name', __('Superviseur'))->label('warning');
        // $grid->column('clients', __('Clients'))->display(function ($clients) {
        //     return $this->clients->pluck('name')->implode(', ');
        // });
        $grid->column('created_at', __('Créé le'))->sortable();

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Gestionnaire::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('GID', __('GID'));
        $show->field('user.name', __('Nom'));
        $show->field('user.email', __('Email'));
        $show->field('responsable.name', __('Responsable'));
        $show->field('superviseur.name', __('Superviseur'));
        // $show->field('clients', __('Clients'))->as(function ($clients) {
        //     return $this->clients->pluck('name')->implode(', ');
        // });
        $show->field('notes', __('Notes'));
        $show->field('created_at', __('Créé le'));
        $show->field('updated_at', __('Mis à jour le'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Gestionnaire());

        $form->text('GID', __('GID'))->rules('required|unique:gestionnaires,GID,{{id}}');
        $form->select('user_id', __('Utilisateur'))
            ->options(User::whereHas('roles', function($query) {
                $query->where('name', 'gestionnaire');
            })->pluck('name', 'id'))
            ->rules('required');

        $form->select('responsable_id', __('Responsable'))
            ->options(User::whereHas('roles', function($query) {
                $query->where('name', 'responsable');
            })->pluck('name', 'id'));

        $form->select('superviseur_id', __('Superviseur'))
            ->options(User::whereHas('roles', function($query) {
                $query->where('name', 'superviseur');
            })->pluck('name', 'id'));

        // $form->multipleSelect('gestionnaire_id', __('Gestionnaire principaux'))
        //     ->options(Client::pluck('name', 'id'));

        // $form->multipleSelect('gestionnaires_secondaires', __('Gestionnaire Supplémentaire'))
        //     ->options(Client::pluck('name', 'id'));

        $form->textarea('notes', __('Notes'));

        return $form;
    }
}