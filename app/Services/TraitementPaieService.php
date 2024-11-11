<?php

namespace App\Services;

use App\Models\TraitementPaie;
use App\Models\FicheClient;
use Illuminate\Support\Facades\Log;

class TraitementPaieService
{
    public function createTraitementPaie(array $data)
    {
        return TraitementPaie::create($data);
    }

    public function updateTraitementPaie(TraitementPaie $traitementPaie, array $data)
    {
        return $traitementPaie->update($data);
    }

    public function updateFicheClient(FicheClient $ficheClient, array $data)
    {
        Log::info('Début de la mise à jour de la fiche client.', ['fiche_client_id' => $ficheClient->id]);

        $updateData = [];

        if (isset($data['reception_variables_file']) && $data['reception_variables_file']->isValid()) {
            $updateData['reception_variables_file'] = $data['reception_variables_file']->store('files');
            Log::info('Fichier réception variables téléchargé.', ['path' => $updateData['reception_variables_file']]);
        }
        if (isset($data['preparation_bp_file']) && $data['preparation_bp_file']->isValid()) {
            $updateData['preparation_bp_file'] = $data['preparation_bp_file']->store('files');
            Log::info('Fichier préparation BP téléchargé.', ['path' => $updateData['preparation_bp_file']]);
        }
        if (isset($data['validation_bp_client_file']) && $data['validation_bp_client_file']->isValid()) {
            $updateData['validation_bp_client_file'] = $data['validation_bp_client_file']->store('files');
            Log::info('Fichier validation BP client téléchargé.', ['path' => $updateData['validation_bp_client_file']]);
        }
        if (isset($data['preparation_envoie_dsn_file']) && $data['preparation_envoie_dsn_file']->isValid()) {
            $updateData['preparation_envoie_dsn_file'] = $data['preparation_envoie_dsn_file']->store('files');
            Log::info('Fichier préparation envoie DSN téléchargé.', ['path' => $updateData['preparation_envoie_dsn_file']]);
        }
        if (isset($data['accuses_dsn_file']) && $data['accuses_dsn_file']->isValid()) {
            $updateData['accuses_dsn_file'] = $data['accuses_dsn_file']->store('files');
            Log::info('Fichier accusés DSN téléchargé.', ['path' => $updateData['accuses_dsn_file']]);
        }
        if (isset($data['nb_bulletins_file']) && $data['nb_bulletins_file']->isValid()) {
            $updateData['nb_bulletins_file'] = $data['nb_bulletins_file']->store('files');
            Log::info('Fichier NB bulletins téléchargé.', ['path' => $updateData['nb_bulletins_file']]);
        }
        if (isset($data['maj_fiche_para_file']) && $data['maj_fiche_para_file']->isValid()) {
            $updateData['maj_fiche_para_file'] = $data['maj_fiche_para_file']->store('files');
            Log::info('Fichier maj fiche para téléchargé.', ['path' => $updateData['maj_fiche_para_file']]);
        }

        $ficheClient->update($updateData);

        Log::info('Fiche client mise à jour avec succès.', ['fiche_client_id' => $ficheClient->id]);

        return $ficheClient;
    }

    public function deleteTraitementPaie(TraitementPaie $traitementPaie)
    {
        return $traitementPaie->delete();
    }
}