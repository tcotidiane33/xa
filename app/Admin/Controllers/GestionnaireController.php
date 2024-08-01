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
        $grid->column('GID', __('GID'))->label();
        $grid->column('user_id', __('Gestionnaire'))->display(function ($user_id) {
            return User::find($user_id)->name ?? 'N/A';
        })->label('danger');
        $grid->column('responsable_id', __('Responsable'))->display(function ($responsable_id) {
            return User::find($responsable_id)->name ?? 'N/A';
        })->label('primary');
        $grid->column('superviseur_id', __('Superviseur'))->display(function ($superviseur_id) {
            return User::find($superviseur_id)->name ?? 'N/A';
        })->label('secondary');
        $grid->column('avatar', __('Avatar'))->display(function ($avatar) {
            return $avatar ? "<img src='" . asset('storage/' . $avatar) . "' width='30' height='30'>" : 'N/A';
        });
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
        $show->field('responsable_id', __('Responsable'))->as(function ($responsable_id) {
            return User::find($responsable_id)->name ?? 'N/A';
        });
        $show->field('superviseur_id', __('Superviseur'))->as(function ($superviseur_id) {
            return User::find($superviseur_id)->name ?? 'N/A';
        });
        $show->field('avatar', __('Avatar'))->as(function ($avatar) {
            return $avatar ? "<img src='" . asset('storage/' . $avatar) . "' width='100' height='100'>" : 'N/A';
        });
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
        $form->select('responsable_id', __('Responsable'))->options(User::pluck('name', 'id'));
        $form->select('superviseur_id', __('Superviseur'))->options(User::pluck('name', 'id'));
        $form->image('avatar', __('Avatar'))->removable();
        $form->textarea('notes', __('NOTES'));

        return $form;
    }
}
