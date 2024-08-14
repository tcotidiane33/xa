<?php

namespace App\Admin\Actions;

use OpenAdmin\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class ValidatePeriodePaie extends RowAction
{
    public $name = 'Valider la période';

    public function handle(Model $model)
    {
        // Vérifiez si la période peut être validée
        if (!$model->canBeValidated()) {
            return $this->response()->error('Cette période ne peut pas être validée.');
        }

        // Validez la période
        $model->validee = true;
        $model->save();

        return $this->response()->success('Période validée avec succès.')->refresh();
    }

    public function dialog()
    {
        $this->confirm('Êtes-vous sûr de vouloir valider cette période ?');
    }
}