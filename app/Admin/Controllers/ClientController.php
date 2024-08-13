<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use App\Models\User;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class ClientController extends AdminController
{
    protected function grid()
    {
        $grid = new Grid(new Client());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Nom'))->editable();
        $grid->column('responsablePaie.name', __('Responsable Paie'))->label();
        $grid->column('gestionnairePrincipal.name', __('Gestionnaire Principal'))->label('info');
        $grid->column('nb_bulletins', __('NB Bulletins'));
        $grid->column('maj_fiche_para', __('Maj fiche para'))->display(function ($value) {
            return $value ? $value : '<span style="color: red;">Non renseigné</span>';
        });
        $grid->column('status', __('Statut'))->using(['actif' => 'Actif', 'inactif' => 'Inactif']);
        $grid->column('created_at', __('Créé le'))->sortable();

        $grid->filter(function($filter){
            $filter->like('name', 'Nom');
            $filter->equal('status')->select(['actif' => 'Actif', 'inactif' => 'Inactif']);
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Client());

        $form->text('name', __('Nom'))->rules('required|max:255');
        $form->select('responsable_paie_id', __('Responsable Paie'))
             ->options(User::role('responsable_paie')->pluck('name', 'id'))
             ->rules('required');
        $form->select('gestionnaire_principal_id', __('Gestionnaire Principal'))
             ->options(User::role('gestionnaire')->pluck('name', 'id'))
             ->rules('required');
        $form->date('date_debut_prestation', __('Date de début de prestation'))->rules('required');
        $form->email('contact_paie', __('Contact Paie'))->rules('email');
        $form->email('contact_comptabilite', __('Contact Comptabilité'))->rules('email');
        $form->number('nb_bulletins', __('Nombre de bulletins'))->rules('required|min:1');
        $form->date('maj_fiche_para', __('Mise à jour fiche paramétrage'));
        $form->text('convention_collective', __('Convention collective'));
        $form->select('status', __('Statut'))->options(['actif' => 'Actif', 'inactif' => 'Inactif'])->rules('required');

        $form->hasMany('gestionnaireSecondaires', 'Gestionnaires secondaires', function (Form\NestedForm $form) {
            $form->select('user_id', 'Gestionnaire')->options(User::role('gestionnaire')->pluck('name', 'id'));
        });

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(Client::findOrFail($id));

        $show->field('name', __('Nom'));
        $show->field('responsablePaie.name', __('Responsable Paie'));
        $show->field('gestionnairePrincipal.name', __('Gestionnaire Principal'));
        $show->field('date_debut_prestation', __('Date de début de prestation'));
        $show->field('contact_paie', __('Contact Paie'));
        $show->field('contact_comptabilite', __('Contact Comptabilité'));
        $show->field('nb_bulletins', __('Nombre de bulletins'));
        $show->field('maj_fiche_para', __('Mise à jour fiche paramétrage'));
        $show->field('convention_collective', __('Convention collective'));
        $show->field('status', __('Statut'))->using(['actif' => 'Actif', 'inactif' => 'Inactif']);

        $show->gestionnaireSecondaires('Gestionnaires secondaires', function ($gestionnaireSecondaires) {
            $gestionnaireSecondaires->resource('/admin/gestionnaire-secondaires');
            $gestionnaireSecondaires->user_id('Nom')->display(function ($userId) {
                return User::find($userId)->name;
            });
        });

        return $show;
    }
}