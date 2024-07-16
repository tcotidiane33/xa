<?php

namespace App\Admin\Controllers;

use App\Models\Habilitation;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class HabilitationController extends AdminController
{
    protected $title = 'Habilitations';

    protected function grid()
    {
        $grid = new Grid(new Habilitation);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('intitule', __('Intitule'));
        $grid->column('libelle', __('Libelle'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Habilitation::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('intitule', __('Intitule'));
        $show->field('libelle', __('Libelle'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Habilitation);

        $form->display('id', __('ID'));
        $form->text('intitule', __('Intitule'))->required();
        $form->textarea('libelle', __('Libelle'));
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
