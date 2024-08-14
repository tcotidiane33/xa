<?php 

namespace App\Admin\Controllers;

use App\Models\Permission;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use OpenAdmin\Admin\Controllers\AdminController;

class PermissionController extends AdminController
{
    protected $title = 'Permissions';

    protected function grid()
    {
        $grid = new Grid(new Permission());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Nom'))->label('warning');
        $grid->column('guard_name', __('Guard Name'))->label('secondary');
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Permission::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Nom'));
        $show->field('guard_name', __('Guard Name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Permission());

        $form->display('id', __('ID'));
        $form->text('name', __('Nom'))->rules('required');
        $form->text('guard_name', __('Guard Name'))->default('web')->rules('required');
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}