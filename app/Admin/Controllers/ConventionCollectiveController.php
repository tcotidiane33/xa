<?php

namespace App\Admin\Controllers;

use App\Models\ConventionCollective;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;

class ConventionCollectiveController extends AdminController
{
    protected $title = 'Conventions Collectives';

    protected function grid()
    {
        $grid = new Grid(new ConventionCollective());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('Nom'))->sortable();
        $grid->column('code', __('Code'))->sortable();
        $grid->column('description', __('Description'))->limit(50);
        $grid->column('created_at', __('Créé le'))->sortable();
        $grid->column('updated_at', __('Mis à jour le'))->sortable();

        $grid->filter(function($filter){
            $filter->like('name', 'Nom');
            $filter->like('code', 'Code');
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(ConventionCollective::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Nom'));
        $show->field('code', __('Code'));
        $show->field('description', __('Description'));
        $show->field('created_at', __('Créé le'));
        $show->field('updated_at', __('Mis à jour le'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new ConventionCollective());

        $form->text('name', __('Nom'))->rules('required|max:255');
        $form->text('code', __('Code'))->rules('required|max:50');
        $form->textarea('description', __('Description'))->rows(5);

        return $form;
    }
}