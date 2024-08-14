<?php

namespace App\Admin\Controllers;

use App\Models\Role;
use App\Models\Permission;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use OpenAdmin\Admin\Controllers\AdminController;

class RoleController extends AdminController
{
    protected $title = 'Rôles';

    protected function grid()
    {
        $grid = new Grid(new Role());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Rôle'))->label();
        $grid->column('permissions', __('Permissions'))->display(function ($permissions) {
            if (is_array($permissions)) {
                return collect($permissions)->pluck('name')->implode(', ');
            }
            return '';
        })->label('danger');
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Role::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Rôle'));
        $show->field('permissions', __('Permissions'))->as(function ($permissions) {
            return $permissions->pluck('name')->implode(', ');
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Role());

        $form->display('id', __('ID'));
        $form->text('name', __('Rôle'))->rules('required');
        $form->multipleSelect('permissions', __('Permissions'))
             ->options(Permission::all()->pluck('name', 'id'))
             ->rules('required');
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}