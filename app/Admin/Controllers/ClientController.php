<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Client;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use OpenAdmin\Admin\Controllers\AdminController;

class ClientController extends AdminController
{
    protected $title = 'Client';

    protected function grid()
    {
        $grid = new Grid(new Client);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'));
        $grid->column('responsable_paie_id', __('Responsable Paie'))->display(function($id) {
            return User::find($id)->name ?? 'N/A';
        });
        $grid->column('gestionnaire_principal_id', __('Gestionnaire Principal'))->display(function($id) {
            return User::find($id)->name ?? 'N/A';
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Client::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Name'));
        $show->field('responsable_paie_id', __('Responsable Paie'))->as(function($id) {
            return User::find($id)->name ?? 'N/A';
        });
        $show->field('gestionnaire_principal_id', __('Gestionnaire Principal'))->as(function($id) {
            return User::find($id)->name ?? 'N/A';
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Client);

        $form->display('id', __('ID'));
        $form->text('name', __('Name'))->required();
        $form->select('responsable_paie_id', __('Responsable Paie'))->options(User::all()->pluck('name', 'id'))->required();
        $form->select('gestionnaire_principal_id', __('Gestionnaire Principal'))->options(User::all()->pluck('name', 'id'))->required();
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
