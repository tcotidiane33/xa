<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Client;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Gestionnaire;
use OpenAdmin\Admin\Controllers\AdminController;

class GestionnaireController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Gestionnaire';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Gestionnaire());

        $grid->column('id', __('Id'))->hide();
        $grid->column('GID', __('GID'));
        $grid->column('user_id', __('Gestionnaire'))->as(function ($user_id) {
            return User::find($user_id)->name ?? 'N/A';
        });
        // $grid->column('nbr_bull', __('Nbr bulletins'));
        // // $grid->column('client_id', __('Client'))->display(function ($client_id) {
        // //     return Client::find($client_id)->name ?? 'N/A';
        // // });
        // $grid->column('maj_fiche_para', __('Maj fiche para'));
        // $grid->column('reception_variable', __('Reception variable'));
        // $grid->column('preparation_bp', __('Preparation BP'));
        // $grid->column('validation_bp_client', __('Validation BP clientt'));
        // $grid->column('preparation_envoie_dsn', __('Preparation et envoie DSN'));
        // $grid->column('accuses_dsn', __('Accuses dsn'));
        // $grid->column('teledec_urssaf', __('TELEDEC URSSAF'));
        $grid->column('notes', __('NOTES'));
        $grid->column('created_at', __('Created at'))->hide();
        $grid->column('updated_at', __('Updated at'))->hide();

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
        $show = new Show(Gestionnaire::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('GID', __('GID'));
        $show->field('user_id', __('Gestionnaire'))->as(function ($user_id) {
            return User::find($user_id)->name ?? 'N/A';
        });
        // $show->field('nbr_bull', __('Nbr bulletins'));
        // // $show->field('client_id', __('Client'))->as(function ($client_id) {
        // //     return Client::find($client_id)->name ?? 'N/A';
        // // });
        // $show->field('maj_fiche_para', __('Maj fiche para'));
        // $show->field('reception_variable', __('Reception variable'));
        // $show->field('preparation_bp', __('Preparation BP'));
        // $show->field('validation_bp_client', __('Validation BP clientt'));
        // $show->field('preparation_envoie_dsn', __('Preparation et envoie DSN'));
        // $show->field('accuses_dsn', __('Accuses dsn'));
        // $show->field('teledec_urssaf', __('TELEDEC URSSAF'));
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
        $form = new Form(new Gestionnaire());

        $form->text('GID', __('GID'));
        $form->select('user_id', __('Gestionnaire'))->options(User::pluck('name', 'id'));
        // $form->number('nbr_bull', __('Nbr bulletins'));
        // // $form->select('client_id', __('Client'))->options(Client::pluck('name', 'id'));
        // $form->date('maj_fiche_para', __('Maj fiche para'))->default(date('Y-m-d'));
        // $form->date('reception_variable', __('Reception variable'))->default(date('Y-m-d'));
        // $form->date('preparation_bp', __('Preparation BP'))->default(date('Y-m-d'));
        // $form->date('validation_bp_client', __('Validation BP clientt'))->default(date('Y-m-d'));
        // $form->date('preparation_envoie_dsn', __('Preparation et envoie DSN'))->default(date('Y-m-d'));
        // $form->date('accuses_dsn', __('Accuses dsn'))->default(date('Y-m-d'));
        // $form->date('teledec_urssaf', __('TELEDEC URSSAF'))->default(date('Y-m-d'));
        $form->textarea('notes', __('NOTES'));

        return $form;
    }
}
