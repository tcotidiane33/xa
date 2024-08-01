<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Models\Ticket;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Controllers\AdminController;

class TicketController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Tickets';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ticket);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('Titre'))->label();
        $grid->column('description', __('Description'));
        $grid->column('status', __('Statut'))->display(function ($status) {
            return ucfirst($status);
        });
        $grid->column('user_id', __('Créateur'))->display(function ($userId) {
            return User::find($userId)->name;
        });
        $grid->column('created_at', __('Créé le'));
        $grid->column('updated_at', __('Mis à jour le'));

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
        $show = new Show(Ticket::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('Titre'));
        $show->field('description', __('Description'));
        $show->field('status', __('Statut'));
        $show->field('user_id', __('Créateur'))->as(function ($userId) {
            return User::find($userId)->name;
        });
        $show->field('created_at', __('Créé le'));
        $show->field('updated_at', __('Mis à jour le'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Ticket);

        $form->display('id', __('ID'));
        $form->text('title', __('Titre'))->rules('required');
        $form->textarea('description', __('Description'))->rules('required');
        $form->select('status', __('Statut'))->options([
            'open' => 'Ouvert',
            'in_progress' => 'En cours',
            'closed' => 'Fermé'
        ])->default('open')->rules('required');
        $form->select('user_id', __('Créateur'))->options(User::all()->pluck('name', 'id'));

        return $form;
    }

    // /**
    //  * Example dashboard.
    //  *
    //  * @param Content $content
    //  * @return Content
    //  */
    // public function dash(Content $content)
    // {
    //     // Example dashboard setup (similar to the one provided)
    //     // Setup for charts, statistics, or other admin panel features
    //     return $content
    //         ->title('Dashboard')
    //         ->description('Sibpilot')
    //         ->body(view('welcome'));
    // }
}
