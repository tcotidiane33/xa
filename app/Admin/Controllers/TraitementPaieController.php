<?php

namespace App\Admin\Controllers;

use App\Models\PeriodePaie;
use App\Models\TraitementPaie;
use App\Models\User;
use App\Models\Client;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\GestionnaireClient; // Assurez-vous d'inclure ce modèle
use OpenAdmin\Admin\Controllers\AdminController;

class TraitementPaieController extends AdminController
{
    protected $title = 'Traitements paie';

    protected function grid()
    {
        $grid = new Grid(new TraitementPaie());

        $grid->column('id', __('Id'))->hide();
        $grid->column('reference', __('Référence'));
        // $grid->column('gestionnaire_id', __('GESTIONNAIRE'))->display(function ($ges_id) {
        //     return User::find($ges_id)->name ?? 'N/A';
        // });
        $grid->column('client_id', __('CLIENT'))->display(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });
        $grid->column('periode_paie_id', __('PERIODE DE PAIE 1/0'))->display(function ($period_id) {
            $periodePaie = PeriodePaie::find($period_id);
            $color = $periodePaie->validee ? 'success' : 'danger';
            return "<span class='badge p-2 bg-{$color}'>{$periodePaie->reference}</span>";
        });
        $grid->column('nbr_bull', __('NOMBRE DE BULLETINS'));
        $grid->column('maj_fiche_para', __('MAJ FICHE PARA'));
        $grid->column('reception_variable', __('RECEPTION VARIABLES'));
        $grid->column('preparation_bp', __('PREPARATION BP'));
        $grid->column('validation_bp_client', __('VALIDATION BP CLIENT'));
        $grid->column('preparation_envoie_dsn', __('PREPARATION ENVOIE DSN'));
        $grid->column('accuses_dsn', __('ACCUSES DSN'));
        // $grid->column('teledec_urssaf', __('TELEDEC URSSAF'));
        $grid->column('notes', __('NOTES'));
        $grid->column('pj_nbr_bull', __('PJ NOMBRE DE BULLETINS'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_maj_fiche_para', __('PJ MAJ FICHE PARA'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_reception_variable', __('PJ RECEPTION VARIABLES'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_preparation_bp', __('PJ PREPARATION BP'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_validation_bp_client', __('PJ VALIDATION BP CLIENT'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('pj_preparation_envoie_dsn', __('PJ PREPARATION ENVOIE DSN'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('link_preparation_envoie_dsn', __('LINK PREPARATION ENVOIE DSN'))->link();
        $grid->column('pj_accuses_dsn', __('PJ ACCUSES DSN'))->display(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $grid->column('link_accuses_dsn', __('LINK ACCUSES DSN'))->link();
        $grid->column('listBoxIsEmpty', __('LISTE VIDE'))->display(function ($isEmpty) {
            return $isEmpty ? 'Oui' : 'Non';
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(TraitementPaie::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('reference', __('Référence'));
        // $show->field('gestionnaire_id', __('GESTIONNAIRE'))->as(function ($ges_id) {
        //     return User::find($ges_id)->name ?? 'N/A';
        // });
        $show->field('client_id', __('CLIENT'))->as(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });
        $show->field('periode_paie_id', __('PERIODE DE PAIE 1/0'))->as(function ($period_id) {
            $periodePaie = PeriodePaie::find($period_id);
            $color = $periodePaie->validee ? 'success' : 'danger';
            return "<span class='badge p-2 bg-{$color}'>{$periodePaie->reference}</span>";
        });
        $show->field('nbr_bull', __('NOMBRE DE BULLETINS'));
        $show->field('maj_fiche_para', __('MAJ FICHE PARA'));
        $show->field('reception_variable', __('RECEPTION VARIABLES'));
        $show->field('preparation_bp', __('PREPARATION BP'));
        $show->field('validation_bp_client', __('VALIDATION BP CLIENT'));
        $show->field('preparation_envoie_dsn', __('PREPARATION ENVOIE DSN'));
        $show->field('accuses_dsn', __('ACCUSES DSN'));
        // $show->field('teledec_urssaf', __('TELEDEC URSSAF'));
        $show->field('notes', __('NOTES'));
        $show->field('pj_nbr_bull', __('PJ NOMBRE DE BULLETINS'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_maj_fiche_para', __('PJ MAJ FICHE PARA'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_reception_variable', __('PJ RECEPTION VARIABLES'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_preparation_bp', __('PJ PREPARATION BP'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_validation_bp_client', __('PJ VALIDATION BP CLIENT'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('pj_preparation_envoie_dsn', __('PJ PREPARATION ENVOIE DSN'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('link_preparation_envoie_dsn', __('LINK PREPARATION ENVOIE DSN'))->link();
        $show->field('pj_accuses_dsn', __('PJ ACCUSES DSN'))->as(function ($multipleImage) {
            return $multipleImage ? '<a href="' . asset('storage/' . $multipleImage) . '" target="_blank">Voir</a>' : 'N/A';
        });
        $show->field('link_accuses_dsn', __('LINK ACCUSES DSN'))->link();
        $show->field('listBoxIsEmpty', __('LISTE VIDE'))->as(function ($isEmpty) {
            return $isEmpty ? 'Oui' : 'Non';
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new TraitementPaie());



        $form->select('client_id', __('CLIENT'))
            ->options(Client::pluck('name', 'id'))
            ->load('gestionnaire_id', '/api/getClientInfo');

        $form->display('gestionnaire_id', __('GESTIONNAIRE'))->default('N/A');
        $form->display('responsable_id', __('RESPONSABLE'))->default('N/A');
        $form->display('superviseur_id', __('SUPERVISEUR'))->default('N/A');
        $form->multipleSelect('gestionnaires_ids', __('Gestionnaires supplémentaires'))
            ->options(User::pluck('name', 'id'))
            ->disable();

        $form->select('periode_paie_id', __('PERIODE DE PAIE 1:Validée / 0:Pas Validée'))->options(PeriodePaie::pluck('reference', 'id'));
        $form->number('nbr_bull', __('NOMBRE DE BULLETINS'))->rules('required');
        $form->multipleImage('pj_nbr_bull', __('PJ NOMBRE DE BULLETINS'))->removable();
        $form->date('maj_fiche_para', __('MAJ FICHE PARA'))->rules('required');
        $form->multipleImage('pj_maj_fiche_para', __('PJ MAJ FICHE PARA'))->removable();
        $form->date('reception_variable', __('RECEPTION VARIABLES'))->rules('required');
        $form->multipleImage('pj_reception_variable', __('PJ RECEPTION VARIABLES'))->removable();
        $form->date('preparation_bp', __('PREPARATION BP'))->rules('required');
        $form->multipleImage('pj_preparation_bp', __('PJ PREPARATION BP'))->removable();
        $form->date('validation_bp_client', __('VALIDATION BP CLIENT'))->rules('required');
        $form->multipleImage('pj_validation_bp_client', __('PJ VALIDATION BP CLIENT'))->removable();
        $form->date('preparation_envoie_dsn', __('PREPARATION ENVOIE DSN'))->rules('required');
        $form->multipleImage('pj_preparation_envoie_dsn', __('PJ PREPARATION ENVOIE DSN'))->removable();
        $form->text('link_preparation_envoie_dsn', __('LINK PREPARATION ENVOIE DSN'));
        $form->date('accuses_dsn', __('ACCUSES DSN'))->rules('required');
        $form->multipleImage('pj_accuses_dsn', __('PJ ACCUSES DSN'))->removable();
        $form->text('link_accuses_dsn', __('LINK ACCUSES DSN'));
        $form->textarea('notes', __('NOTES'));
        $form->display('teledec_urssaf', __('TELEDEC URSSAF'));

        $form->saving(function (Form $form) {
            $form->model()->listBoxIsEmpty = $form->model()->checkIfAllFieldsFilled();
    
            $fileFields = [
                'pj_nbr_bull',
                'pj_maj_fiche_para',
                'pj_reception_variable',
                'pj_preparation_bp',
                'pj_validation_bp_client',
                'pj_preparation_envoie_dsn',
                'pj_accuses_dsn'
            ];
    
            foreach ($fileFields as $field) {
                if ($form->{$field}) {
                    $form->model()->{$field} = $form->{$field}->store('uploads/traitements_paie');
                }
            }
        });

        return $form;
    }
}
