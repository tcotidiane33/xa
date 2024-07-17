<?php

namespace App\Admin\Controllers;

use App\Models\PeriodePaie;
use App\Models\TraitementPaie;
use App\Models\User;
use App\Models\Client;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Gestionnaire;
use OpenAdmin\Admin\Controllers\AdminController;

class TraitementPaieController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Traitements paie';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TraitementPaie());

        $grid->column('id', __('Id'))->hide();
        $grid->column('reference', __('Référence'));
        $grid->column('gestionnaire_id', __('GESTIONNAIRE'))->display(function ($ges_id) {
            return User::find($ges_id)->name ?? 'N/A';
        });
        $grid->column('client_id', __('CLIENT'))->display(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });
        $grid->column('periode_paie_id', __('PERIODE DE PAIE 1/0'))->display(function ($period_id) {
            $periodePaie = PeriodePaie::find($period_id);
            $color = $periodePaie->validee ? 'success' : 'danger';
            return "<span class='badge p-2 bg-{$color}'>{$periodePaie->reference}</span>";
        });
        // $grid->column('periode_paie_id', __('PERIODE DE PAIE 1/0'))->display(function ($period_id) {
        //     return PeriodePaie::find($period_id)->reference ?? 'N/A';
        // });
        $grid->column('nbr_bull', __('NOMBRE DE BULLETINS'));
        $grid->column('maj_fiche_para', __('MAJ FICHE PARA'));
        $grid->column('reception_variable', __('RECEPTION_VARIABLES'));
        $grid->column('preparation_bp', __('PREPARATION_BP'));
        $grid->column('validation_bp_client', __('VALIDATION_BP_CLIENT'));
        $grid->column('preparation_envoie_dsn', __('PREPARATION_ENVOIE_DSN'));
        $grid->column('accuses_dsn', __('ACCUSES_DSN'));
        $grid->column('teledec_urssaf', __('TELEDEC_URSSAF'));
        $grid->column('notes', __('NOTES'));

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
        $show = new Show(TraitementPaie::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('reference', __('Référence'));
        $show->field('gestionnaire_id', __('GESTIONNAIRE'))->as(function ($ges_id) {
            return User::find($ges_id)->name ?? 'N/A';
        });
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
        $show->field('reception_variable', __('RECEPTION_VARIABLES'));
        $show->field('preparation_bp', __('PREPARATION_BP'));
        $show->field('validation_bp_client', __('VALIDATION_BP_CLIENT'));
        $show->field('preparation_envoie_dsn', __('PREPARATION_ENVOIE_DSN'));
        $show->field('accuses_dsn', __('ACCUSES_DSN'));
        $show->field('teledec_urssaf', __('TELEDEC_URSSAF'));
        $show->field('notes', __('NOTES'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TraitementPaie());

        // $form->text('GID', __('Nom du Gestionnaire'));
        // $form->text('reference', __('Référence'));
        $form->select('gestionnaire_id', __('GESTIONNAIRE'))->options(User::pluck('name', 'id'));
        $form->select('client_id', __('CLIENT'))->options(Client::pluck('name', 'id'));
        $form->select('periode_paie_id', __('PERIODE DE PAIE 1:Validée / 0:Pas Validée'))->options(PeriodePaie::pluck('reference', 'id'));
        $form->number('nbr_bull', __('NOMBRE DE BULLETINS'));
        $form->date('maj_fiche_para', __('MAJ FICHE PARA'));
        $form->date('reception_variable', __('RECEPTION_VARIABLES'));
        $form->date('preparation_bp', __('PREPARATION_BP'));
        $form->date('validation_bp_client', __('VALIDATION_BP_CLIENT'));
        $form->date('preparation_envoie_dsn', __('PREPARATION_ENVOIE_DSN'));
        $form->date('accuses_dsn', __('ACCUSES_DSN'));
        $form->date('teledec_urssaf', __('TELEDEC_URSSAF'));
        $form->textarea('notes', __('NOTES'));

        return $form;
    }
}
