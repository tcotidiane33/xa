<?php

namespace App\Services;

use App\Models\TraitementPaie;
use App\Models\FicheClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TraitementPaieService
{
    public function createTraitementPaie(array $data)
    {
        // Gérer les uploads de fichiers
        $fileFields = [
            'maj_fiche_para_file',
            'reception_variables_file',
            'preparation_bp_file',
            'validation_bp_client_file',
            'preparation_envoi_dsn_file',
            'accuses_dsn_file'
        ];

        foreach ($fileFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $data[$field]->store('traitements_paie');
            }
        }

        // La référence sera automatiquement générée grâce au boot method du modèle
        $traitementPaie = TraitementPaie::create($data);

        // Lier les fichiers à la fiche client
        $ficheClient = FicheClient::where('client_id', $data['client_id'])
                                  ->where('periode_paie_id', $data['periode_paie_id'])
                                  ->first();

        if ($ficheClient) {
            foreach ($fileFields as $field) {
                if (isset($data[$field])) {
                    $ficheClient->$field = $data[$field];
                }
            }
            $ficheClient->save();
        }

        return $traitementPaie;
    }

    public function updateTraitementPaie(TraitementPaie $traitementPaie, array $data)
    {
        // Gérer les uploads de fichiers
        $fileFields = [
            'maj_fiche_para_file',
            'reception_variables_file',
            'preparation_bp_file',
            'validation_bp_client_file',
            'preparation_envoi_dsn_file',
            'accuses_dsn_file'
        ];

        foreach ($fileFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = $data[$field]->store('traitements_paie');
            }
        }

        $traitementPaie->update($data);

        // Lier les fichiers à la fiche client
        $ficheClient = FicheClient::where('client_id', $data['client_id'])
                                  ->where('periode_paie_id', $data['periode_paie_id'])
                                  ->first();

        if ($ficheClient) {
            foreach ($fileFields as $field) {
                if (isset($data[$field])) {
                    $ficheClient->$field = $data[$field];
                }
            }
            $ficheClient->save();
        }

        return $traitementPaie;
    }

    public function deleteTraitementPaie(TraitementPaie $traitementPaie)
    {
        $traitementPaie->delete();
    }
}