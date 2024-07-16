<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Client;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Gestionnaire;
use App\Models\GestionnaireClient;
use OpenAdmin\Admin\Controllers\AdminController;

class GestionnaireClientController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gestionnaire Client';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GestionnaireClient());

        $grid->column('id', __('Id'))->hide();
        $grid->column('gestionnaire_id', __('Gestionnaire'))->display(function ($ges_id) {
            return User::find($ges_id)->name ?? 'N/A';
        });
        $grid->column('client_id', __('Client'))->display(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });

        $grid->column('is_principal', __('Est Principal ?'))->bool();


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
        $show = new Show(GestionnaireClient::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('gestionnaire_id', __('Gestionnaire'))->as(function ($ges_id) {
            return User::find($ges_id)->name ?? 'N/A';
        });
        $show->field('client_id', __('Client'))->as(function ($client_id) {
            return Client::find($client_id)->name ?? 'N/A';
        });

        $show->field('is_principal', __('Est Principal ?'))->bool();


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GestionnaireClient());

        // $form->text('GID', __('GID'));
        $form->select('gestionnaire_id', __('Gestionnaire'))->options(User::pluck('name', 'id'));
        $form->select('client_id', __('Client'))->options(Client::pluck('name', 'id'));
        $form->switch('is_principal', __('Est Principal ?'))->default(false);

        ;

        return $form;
    }
}
