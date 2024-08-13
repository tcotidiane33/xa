<?php

namespace App\Admin\Actions;

use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class ViewTraitementsPaie extends RowAction
{
    public $name = 'Voir les traitements de paie';

    public function handle(Model $model)
    {
        // Logique pour afficher les traitements de paie
        return $this->response()->success('Traitements de paie affichés')->refresh();
    }

    public function href()
    {
        return admin_url('traitements-paie?client_id='.$this->getKey());
    }
}