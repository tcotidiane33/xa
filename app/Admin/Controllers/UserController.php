<?php

namespace App\Admin\Controllers;

use App\Models\Domaine;
use App\Models\Fonction;
use App\Models\Habilitation;
use App\Models\User;
use App\Models\Role;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class UserController extends AdminController
{
    protected $title = 'User';

    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Name'))->label();
        $grid->column('email', __('Email'));
        $grid->column('role_id', __('Role'))->display(function($roleId) {
            return Role::find($roleId)->name ?? 'N/A';
        })->label('primary');
        $grid->column('fonction_id', __('Fonction'))->display(function($fonctionId) {
            return Fonction::find($fonctionId)->intitule ?? 'N/A';
        })->label('secondary');
        $grid->column('domaine_id', __('Domaine'))->display(function($domaineId) {
            return Domaine::find($domaineId)->intitule ?? 'N/A';
        })->label('warning');
        $grid->column('habilitation_id', __('Habilitation'))->display(function($habilitationId) {
            return Habilitation::find($habilitationId)->intitule ?? 'N/A';
        })->label('danger');
        $grid->column('password', __('Password'));

        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('role_id', __('Role'))->as(function($roleId) {
            return Role::find($roleId)->name ?? 'N/A';
        });
        $show->field('fonction_id', __('Fonction'))->display(function($fonctionId) {
            return Fonction::find($fonctionId)->intitule ?? 'N/A';
        });
        $show->field('domaine_id', __('Domaine'))->display(function($domaineId) {
            return Domaine::find($domaineId)->intitule ?? 'N/A';
        });
        $show->field('habilitation_id', __('Habilitations'))->display(function($habilitationId) {
            return Habilitation::find($habilitationId)->intitule ?? 'N/A';
        });
        $show->field('password', __('Password'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new User);

        $form->display('id', __('ID'));
        $form->text('name', __('Name'))->required();
        $form->email('email', __('Email'))->required();
        $form->password('password', __('Password'))->required();
        $form->select('role_id', __('Role'))->options(Role::all()->pluck('name', 'id'));
        $form->select('fonction_id', __('Fonction'))->options(Fonction::all()->pluck('intitule', 'id'));
        $form->select('domaine_id', __('Domaine d\'intervention'))->options(Domaine::all()->pluck('intitule', 'id'));
        $form->select('habilitation_id', __('Habilitations'))->options(Habilitation::all()->pluck('intitule', 'id'));
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
