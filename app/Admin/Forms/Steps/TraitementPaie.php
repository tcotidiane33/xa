<?php

namespace App\Admin\Forms\Steps;

// use Encore\Admin\Widgets\StepForm;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Widgets\StepForm;

class TraitementPaie extends StepForm
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Basic info';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $this->clear();

        return $this->next($request->all());
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->select('client_id', __('CLIENT'))
            ->options(Client::pluck('name', 'id'))
            ->load('gestionnaire_id', '/api/getClientInfo');

        $this->display('gestionnaire_id', __('GESTIONNAIRE'))->default('N/A');
        $this->display('responsable_id', __('RESPONSABLE'))->default('N/A');
        $this->display('superviseur_id', __('SUPERVISEUR'))->default('N/A');
        $this->multipleSelect('gestionnaires_ids', __('Gestionnaires supplémentaires'))
            ->options(User::pluck('name', 'id'))
            ->disable();

        $this->select('periode_paie_id', __('PERIODE DE PAIE 1:Validée / 0:Pas Validée'))->options(PeriodePaie::pluck('reference', 'id'));
        $this->number('nbr_bull', __('NOMBRE DE BULLETINS'))->rules('required');
        $this->multipleImage('pj_nbr_bull', __('PJ NOMBRE DE BULLETINS'))->removable();
        $this->date('maj_fiche_para', __('MAJ FICHE PARA'))->rules('required');
        $this->multipleImage('pj_maj_fiche_para', __('PJ MAJ FICHE PARA'))->removable();
        $this->date('reception_variable', __('RECEPTION VARIABLES'))->rules('required');
        $this->multipleImage('pj_reception_variable', __('PJ RECEPTION VARIABLES'))->removable();
        $this->date('preparation_bp', __('PREPARATION BP'))->rules('required');
        $this->multipleImage('pj_preparation_bp', __('PJ PREPARATION BP'))->removable();
        $this->date('validation_bp_client', __('VALIDATION BP CLIENT'))->rules('required');
        $this->multipleImage('pj_validation_bp_client', __('PJ VALIDATION BP CLIENT'))->removable();
        $this->date('preparation_envoie_dsn', __('PREPARATION ENVOIE DSN'))->rules('required');
        $this->multipleImage('pj_preparation_envoie_dsn', __('PJ PREPARATION ENVOIE DSN'))->removable();
        $this->text('link_preparation_envoie_dsn', __('LINK PREPARATION ENVOIE DSN'));
        $this->date('accuses_dsn', __('ACCUSES DSN'))->rules('required');
        $this->multipleImage('pj_accuses_dsn', __('PJ ACCUSES DSN'))->removable();
        $this->text('link_accuses_dsn', __('LINK ACCUSES DSN'));
        $this->textarea('notes', __('NOTES'));
        $this->display('teledec_urssaf', __('TELEDEC URSSAF'));

        // Ajout de la colonne pour la barre de progression
        $this->number('progress', __('Progress'))->default(0);
    }
}
