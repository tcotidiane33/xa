<?php

namespace App\Admin\Forms;

use App\Models\Client;
use App\Models\PeriodePaie;
use App\Models\User;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Widgets\Form;

class TraitementPaie extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'Traitements de paie';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        // Traitement des données du formulaire et mise à jour de la progression
        $data = $request->all();

        // Mettre à jour la barre de progression
        $totalSteps = 10; // Nombre total d'étapes
        $completedSteps = 0;

        if (!empty($data['periode_paie_id']))
            $completedSteps++;
        if (!empty($data['nbr_bull']))
            $completedSteps++;
        if (!empty($data['maj_fiche_para']))
            $completedSteps++;
        if (!empty($data['reception_variable']))
            $completedSteps++;
        if (!empty($data['preparation_bp']))
            $completedSteps++;
        if (!empty($data['validation_bp_client']))
            $completedSteps++;
        if (!empty($data['preparation_envoie_dsn']))
            $completedSteps++;
        if (!empty($data['accuses_dsn']))
            $completedSteps++;
        if (!empty($data['link_preparation_envoie_dsn']))
            $completedSteps++;
        if (!empty($data['link_accuses_dsn']))
            $completedSteps++;

        $progress = ($completedSteps / $totalSteps) * 100;
        $data['progress'] = $progress;

        // Sauvegarde des données (vous pouvez remplacer par le code de sauvegarde réel)
        // Exemple :
        // TraitementPaie::create($data);

        admin_success('Processed successfully.');

                // or an error message
        admin_error('Une erreur s\'est produite.');

        $result = 0;// Calculate and obtain data...

        return back()->with(['result' => $result]);
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

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'client_id' => 1,
            'gestionnaire_id' => 'N/A',
            'responsable_id' => 'N/A',
            'superviseur_id' => 'N/A',
            'gestionnaires_ids' => [],
            'periode_paie_id' => 1,
            'nbr_bull' => 10,
            'pj_nbr_bull' => '',
            'maj_fiche_para' => now(),
            'pj_maj_fiche_para' => '',
            'reception_variable' => now(),
            'pj_reception_variable' => '',
            'preparation_bp' => now(),
            'pj_preparation_bp' => '',
            'validation_bp_client' => now(),
            'pj_validation_bp_client' => '',
            'preparation_envoie_dsn' => now(),
            'pj_preparation_envoie_dsn' => '',
            'link_preparation_envoie_dsn' => 'http://example.com',
            'accuses_dsn' => now(),
            'pj_accuses_dsn' => '',
            'link_accuses_dsn' => 'http://example.com',
            'notes' => 'Some notes',
            'teledec_urssaf' => 'Some info',
            'progress' => 0,
        ];
    }
}
