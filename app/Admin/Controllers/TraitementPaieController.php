<?php

namespace App\Admin\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Client;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use App\Models\PeriodePaie;
use App\Models\TraitementPaie;
use Illuminate\Support\Facades\Auth;
use OpenAdmin\Admin\Controllers\AdminController;

class TraitementPaieController extends AdminController
{
//     public function __construct()
// {
//     $this->middleware('role:admin|responsable|gestionnaire');
// }

    protected function grid()
    {
        $grid = new Grid(new TraitementPaie());

        // if (auth()->user()->hasRole('gestionnaire')) {
        //     $grid->model()->where('gestionnaire_id', auth()->id());
        // } elseif (auth()->user()->hasRole('responsable')) {
        //     $gestionnaires = User::role('gestionnaire')->where('responsable_id', auth()->id())->pluck('id');
        //     $grid->model()->whereIn('gestionnaire_id', $gestionnaires);
        // }

        $grid->model()->orderBy('id', 'desc');

        $grid->column('client.name', __('Client'));
        $grid->column('periodePaie.debut', __('Période'))->display(function ($value) {
            return $value ? date('m/Y', strtotime($value)) : '';
        });
        $grid->column('gestionnaire.name', __('Gestionnaire'));
        $grid->column('client.nb_bulletins', __('NB Bulletins'));
        $grid->column('reception_variables', __('Réception variables'))->display(function ($value) {
            return $this->colorizeDate($value);
        });
    
        $grid->column('preparation_bp', __('Préparation BP'))->display(function ($value) {
            return $this->colorizeDate($value, $this->reception_variables);
        });
        $grid->column('validation_bp_client', __('Validation BP client'));
        $grid->column('preparation_envoi_dsn', __('Préparation et envoi DSN'));
        $grid->column('accuses_dsn', __('Accusés DSN'));
        $grid->column('teledec_urssaf', __('TELEDEC URSSAF'));

        $grid->filter(function($filter){
            $filter->equal('periode_paie_id', 'Période')->select(PeriodePaie::pluck('debut', 'id'));
            $filter->equal('client_id', 'Client')->select(Client::pluck('name', 'id'));
            
            $user = Auth::guard('admin')->user();
            if ($user instanceof Administrator && ($user->hasRole('admin') || $user->hasRole('responsable'))) {
                $filter->equal('gestionnaire_id', 'Gestionnaire')->select(User::role('gestionnaire')->pluck('name', 'id'));
            }
        });

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new TraitementPaie());

        $form->select('client_id', __('Client'))->options(Client::pluck('name', 'id'))->rules('required');
        $form->select('periode_paie_id', __('Période de paie'))->options(PeriodePaie::pluck('debut', 'id'))->rules('required');
        $form->select('gestionnaire_id', __('Gestionnaire'))->options(User::role('gestionnaire')->pluck('name', 'id'))->rules('required');
        $form->date('reception_variables', __('Réception variables'));
        $form->date('preparation_bp', __('Préparation BP'));
        $form->date('validation_bp_client', __('Validation BP client'));
        $form->date('preparation_envoi_dsn', __('Préparation et envoi DSN'));
        $form->date('accuses_dsn', __('Accusés DSN'));
        $form->date('teledec_urssaf', __('TELEDEC URSSAF'));
        $form->textarea('notes', __('Notes'));

        return $form;
    }

    protected function colorizeDate($date, $previousDate = null)
{
    if (!$date) {
        return '<span style="color: red;">Non renseigné</span>';
    }

    $date = Carbon::parse($date);
    $today = Carbon::today();

    if ($previousDate && $date->diffInDays(Carbon::parse($previousDate)) > 3) {
        return '<span style="color: orange;">' . $date->format('d/m/Y') . '</span>';
    }

    if ($date->lt($today)) {
        return '<span style="color: green;">' . $date->format('d/m/Y') . '</span>';
    }

    return $date->format('d/m/Y');
}
}