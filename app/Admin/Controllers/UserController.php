<?php

namespace App\Admin\Controllers;

use App\Models\User;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use Spatie\Permission\Models\Role;

class UserController extends AdminController
{
    protected $title = 'Utilisateurs';

    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Nom'))->sortable()->label();
        $grid->column('email', __('Email'))->sortable()->label('danger');
        $grid->column('roles', __('Rôles'))->display(function ($roles) {
            return $this->roles->pluck('name')->implode(', ');
        })->label('secondary');
        $grid->column('created_at', __('Créé le'))->sortable();

        $grid->filter(function($filter){
            $filter->like('name', 'Nom');
            $filter->like('email', 'Email');
            $filter->equal('roles.name', 'Rôle')->select(Role::pluck('name', 'name'));
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Nom'));
        $show->field('email', __('Email'));
        $show->field('roles', __('Rôles'))->as(function ($roles) {
            return $this->roles->pluck('name')->implode(', ');
        });
 
        $show->field('created_at', __('Créé le'));
        $show->field('updated_at', __('Mis à jour le'));

        return $show;
    }

    protected function form()
{
    $form = new Form(new User());

    $form->text('name', __('Nom'))->rules('required');
    $form->email('email', __('Email'))->rules('required|email|unique:users,email,{{id}}');
    $form->password('password', __('Mot de passe'))->rules('required|min:6')->default(function ($form) {
        return $form->model()->password;
    });

    $form->multipleSelect('roles', __('Rôles'))->options(Role::pluck('name', 'id'));


    $form->saving(function (Form $form) {
        if ($form->password && $form->model()->password != $form->password) {
            $form->password = bcrypt($form->password);
        }
    });

    return $form;
}
}