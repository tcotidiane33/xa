<?php

namespace App\Admin\Controllers;

use App\Models\Client;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\PeriodePaie;
use OpenAdmin\Admin\Controllers\AdminController;

class PeriodePaieController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Périodes paie';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PeriodePaie());

        $grid->column('id', __('Id'))->hide();
        $grid->column('reference', __('Référence'))->label('primary');
        $grid->column('debut', __('Date de début'))->label();
        $grid->column('fin', __('Date de fin'))->label('danger');
        $grid->column('client_id', __('Client'))->display(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        })->label('warning');
        $grid->column('validee', __('Validité'))->bool(); // Display as boolean

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PeriodePaie::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('reference', __('Référence'))->label('primary');
        $show->field('debut', __('Date de début'))->label();
        $show->field('fin', __('Date de fin'))->label('danger');
        $show->field('client_id', __('Client'))->as(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        })->label('warning');
        $show->field('validee', __('Validité'))->bool(); // Display as boolean

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PeriodePaie());

        $form->text('reference', __('Référence'))->readonly();
        $form->date('debut', __('Date de début'))->required();
        $form->date('fin', __('Date de fin'))->required();
        $form->select('client_id', __('Client'))->options(Client::pluck('name', 'id'));
        $form->switch('validee', __('Validité'))->default(false);

        return $form;
    }
}
