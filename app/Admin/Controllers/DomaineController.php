<?php

namespace App\Admin\Controllers;

use App\Models\Domaine;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class DomaineController extends AdminController
{
    protected $title = 'Domaine';

    protected function grid()
    {
        $grid = new Grid(new Domaine);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('intitule', __('Intitule'))->label('info');
        $grid->column('libelle', __('Libelle'))->label('secondary');
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Domaine::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('intitule', __('Intitule'));
        $show->field('libelle', __('Libelle'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Domaine);

        $form->display('id', __('ID'));
        $form->text('intitule', __('Intitule'))->required();
        $form->textarea('libelle', __('Libelle'));
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        return $form;
    }
}
