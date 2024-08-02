<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use App\Models\User;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use OpenAdmin\Admin\Controllers\AdminController;

class PostController extends AdminController
{
    protected $title = 'Post';

    protected function grid()
    {
        $grid = new Grid(new Post());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('user.name', __('User'));
        $grid->column('content', __('Content'));
        $grid->column('mentions', __('Mentions'))->display(function ($mentions) {
            return collect(json_decode($mentions, true))->pluck('name')->implode(', ');
        });
        $grid->column('attachments', __('Attachments'))->display(function ($attachments) {
            return collect(json_decode($attachments, true))->map(function ($attachment) {
                return "<a href='/storage/$attachment' target='_blank'>Attachment</a>";
            })->implode(', ');
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Post::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('user.name', __('User'));
        $show->field('content', __('Content'));
        $show->field('mentions', __('Mentions'))->as(function ($mentions) {
            return collect(json_decode($mentions, true))->pluck('name')->implode(', ');
        });
        $show->field('attachments', __('Attachments'))->as(function ($attachments) {
            return collect(json_decode($attachments, true))->map(function ($attachment) {
                return "<a href='/storage/$attachment' target='_blank'>Attachment</a>";
            })->implode(', ');
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Post());

        $form->select('user_id', __('User'))->options(User::pluck('name', 'id'))->required();
        $form->textarea('content', __('Content'))->required();
        $form->multipleSelect('mentions', __('Mentions'))->options(User::pluck('name', 'id'))->saving(function ($value) {
            return json_encode(User::whereIn('id', $value)->get(['id', 'name'])->toArray());
        });
        $form->multipleFile('attachments', __('Attachments'))->saving(function ($files) {
            return json_encode(array_map(fn($file) => $file->store('attachments'), $files));
        });

        return $form;
    }
}
