<?php

namespace App\Services;

use App\Models\TraitementPaie;

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

    public function deleteTraitementPaie(TraitementPaie $traitementPaie)
    {
        return $traitementPaie->delete();
    }
}