<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Client;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Gestionnaire;
use App\Models\GestionnaireClient;
use OpenAdmin\Admin\Controllers\AdminController;

class GestionnaireClientController extends AdminController
{
    protected $title = 'Gestionnaire Client';

    protected function grid()
    {
        $grid = new Grid(new GestionnaireClient());

        $grid->column('id', __('Id'))->hide();
        $grid->column('client_id', __('Client'))->display(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });
        $grid->column('gestionnaire_id', __('Gestionnaire'))->display(function ($ges_id) {
            return User::find($ges_id)->name ?? 'N/A';
        });
        $grid->column('is_principal', __('Est Principal ?'))->bool();
        $grid->column('gestionnaires_ids', __('Gestionnaires supplémentaires'))->display(function ($gestionnaires_ids) {
            if (is_array($gestionnaires_ids) && count($gestionnaires_ids) > 0) {
                return User::whereIn('id', $gestionnaires_ids)->pluck('name')->implode(', ');
            }
            return 'Aucun';
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(GestionnaireClient::findOrFail($id));

        $show->field('id', __('Id'));

        $show->field('client_id', __('Client'))->as(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });
        $show->field('gestionnaire_id', __('Gestionnaire'))->as(function ($ges_id) {
            return User::find($ges_id)->name ?? 'N/A';
        });
        $show->field('is_principal', __('Est Principal ?'))->bool();
        $show->field('gestionnaires_ids', __('Gestionnaires supplémentaires'))->as(function ($gestionnaires_ids) {
            if (is_array($gestionnaires_ids) && count($gestionnaires_ids) > 0) {
                return User::whereIn('id', $gestionnaires_ids)->pluck('name')->implode(', ');
            }
            return 'Aucun';
        });

        return $show;
    }

    protected function form()
    {
        $form = new Form(new GestionnaireClient());

        $form->select('client_id', __('Client'))->options(Client::pluck('name', 'id'));
        $form->multipleSelect('gestionnaires_ids', __('Gestionnaires supplémentaires'))->options(User::pluck('name', 'id'));
        $form->select('gestionnaire_id', __('Gestionnaire'))->options(User::pluck('name', 'id'));
        $form->switch('is_principal', __('Est Principal ?'))->default(false);

        return $form;
    }
}

