<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Gestionnaire;
use App\Models\GestionnaireClient;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use OpenAdmin\Admin\Controllers\AdminController;

class GestionnaireClientController extends AdminController
{
    protected $title = 'Relation Gestionnaire-Client';

    protected function grid()
    {
        $grid = new Grid(new GestionnaireClient());


        $grid->column('id', __('Id'))->sortable();
        $grid->column('client.name', __('Client'))->sortable();
        $grid->column('gestionnaire.name', __('Gestionnaire'))->sortable()->label();
        $grid->column('is_principal', __('Principal'))->bool();
        $grid->column('gestionnaires_secondaires', __('Gestionnaires secondaires'))->display(function ($gestionnaires) {
            if (empty($gestionnaires)) return 'Aucun';
            return User::whereIn('id', $gestionnaires)->pluck('name')->implode(', ');
        });
        // $grid->column('gestionnaire.responsable.name', __('Responsable'));
        // $grid->column('gestionnaire.superviseur.name', __('Superviseur'));

        $grid->filter(function ($filter) {
            $filter->like('client.name', 'Client');
            $filter->like('gestionnaire.name', 'Gestionnaire');
            $filter->equal('is_principal', 'Principal')->select([0 => 'Non', 1 => 'Oui']);
        });

        // Ajoutez cette ligne pour déboguer
        // $grid->model()->dd();


        return $grid;
    }

    protected function detail($id)
{
    $show = new Show(GestionnaireClient::findOrFail($id));

    $show->field('id', __('Id'));
    $show->field('client.name', __('Client'));
    $show->field('gestionnaire.name', __('Gestionnaire'));
    $show->field('is_principal', __('Principal'))->as(function ($isPrincipal) {
        return $isPrincipal ? 'Oui' : 'Non';
    });
    $show->field('gestionnaires_secondaires', __('Gestionnaires secondaires'))->as(function ($gestionnaires) {
        if (empty($gestionnaires)) return 'Aucun';
        return User::whereIn('id', $gestionnaires)->pluck('name')->implode(', ');
    });
    $show->field('notes', __('Notes'));
    return $show;
}

    protected function form()
    {
        $form = new Form(new GestionnaireClient());

        $form->select('client_id', __('Client'))
            ->options(Client::pluck('name', 'id'))
            ->rules('required');

            $form->select('gestionnaire_id', __('Gestionnaire principal'))
            ->options(User::whereHas('gestionnaire')->pluck('name', 'id'))
            ->rules('required');
        
       
        $form->switch('is_principal', __('Est Principal ?'))->default(false);

        $form->list('gestionnaires_secondaires', __('Gestionnaires secondaires'))
        ->options(Gestionnaire::with('user')->get()->pluck('user.name', 'id')->toArray())
        ->help('Sélectionnez les gestionnaires secondaires');

        $form->textarea('notes', __('Notes'))->rows(5);

        $form->saving(function (Form $form) {
            // Convertir les gestionnaires secondaires en JSON si ce n'est pas déjà fait
            if (is_array($form->gestionnaires_secondaires)) {
                $form->gestionnaires_secondaires = json_encode($form->gestionnaires_secondaires);
            } elseif (empty($form->gestionnaires_secondaires)) {
                $form->gestionnaires_secondaires = null;
            }

            // Récupérer les informations du gestionnaire principal
            $gestionnaire = Gestionnaire::find($form->gestionnaire_id);
            // $form->responsable_id = $gestionnaire->responsable_id;
            // $form->superviseur_id = $gestionnaire->superviseur_id;
        });


        return $form;
    }

}