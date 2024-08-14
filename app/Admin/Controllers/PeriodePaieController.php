<?php

namespace App\Admin\Controllers;

use App\Models\PeriodePaie;
use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use Illuminate\Http\Request;
use App\Admin\Actions\ValidatePeriodePaie;


class PeriodePaieController extends AdminController
{
    protected function grid()
    {
        $grid = new Grid(new PeriodePaie());

        $grid->column('id', __('ID'));
        $grid->column('debut', __('Début'))->sortable();
        $grid->column('fin', __('Fin'))->sortable();
        $grid->column('validee', __('Validée'))->bool();

        $grid->actions(function ($actions) {
            $actions->add(new ValidatePeriodePaie);
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new PeriodePaie());

        $form->date('debut', __('Début'))->rules('required');
        $form->date('fin', __('Fin'))->rules('required');
        $form->switch('validee', __('Validée'));

        return $form;
    }

    public function validate(Request $request, $id)
    {
        $periodePaie = PeriodePaie::findOrFail($id);
        
        if (!$periodePaie->canBeValidated()) {
            return response()->json(['error' => 'Cette période ne peut pas être validée.'], 422);
        }

        $periodePaie->validee = true;
        $periodePaie->save();

        return response()->json(['message' => 'Période validée avec succès.']);
    }
}