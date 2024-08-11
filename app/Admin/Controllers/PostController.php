<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Attachment;
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

        $grid->column('id', __('ID'))->sortable()->totalRow();
        $grid->column('title', __('Titre'))->sortable()->label('danger');
        $grid->column('user.name', __('User'))->label();
        $grid->column('content', __('Content'))->label('info');
        $grid->column('mentions', __('Mentions'))->display(function ($mentions) {
            return $this->mentions->pluck('name')->implode(', ');
        });
        $grid->column('attachments', __('Attachments'))->display(function () {
            return Attachment::where('post_id', $this->id)->get()->map(function ($attachment) {
                return "<a href='/storage/{$attachment->file_path}' target='_blank'>Attachment</a>";
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
        $show->field('title', __('Titre'))->label();
        $show->field('user.name', __('User'));
        $show->field('content', __('Content'));
        $show->field('mentions', __('Mentions'))->as(function () {
            return $this->mentions->pluck('name')->implode(', ');
        });
        $show->field('attachments', __('Attachments'))->as(function () {
            return Attachment::where('post_id', $this->id)->get()->map(function ($attachment) {
                return "<a href='/storage/{$attachment->file_path}' target='_blank'>Attachment</a>";
            })->implode(', ');
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Post());

        $form->text('title', __('Titre'))->required();
        $form->select('user_id', __('User'))->options(User::pluck('name', 'id'))->required();
        $form->textarea('content', __('Content'))->required();
        $form->multipleSelect('mentions', __('Mentions'))->options(User::pluck('name', 'id'));
        $form->multipleFile('attachments', __('Attachments'))->removable();

        $form->saving(function (Form $form) {
            // Debugging output
            \Log::info('Saving form data', ['attachments' => $form->attachments]);

            // Handle the 'mentions' field
            if ($form->mentions) {
                $form->mentions = array_map('intval', $form->mentions);
            }

            // Handle the 'attachments' field
            $attachments = [];
            if (is_array($form->attachments)) {
                foreach ($form->attachments as $file) {
                    $attachments[] = $file->store('attachments');
                }
            } elseif (is_string($form->attachments)) {
                $attachments = json_decode($form->attachments, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($attachments)) {
                    foreach ($attachments as $file) {
                        $attachments[] = $file->store('attachments');
                    }
                } else {
                    $attachments[] = $form->attachments;
                }
            }

            $form->attachments = json_encode($attachments);
        });


        $form->saved(function (Form $form) {
            // Sync mentions after the post is saved
            if ($form->mentions) {
                $form->model()->mentions()->sync($form->mentions);
            }

            // Save attachments to the separate table
            $attachments = json_decode($form->model()->attachments, true);
            Attachment::where('post_id', $form->model()->id)->delete();
            foreach ($attachments as $filePath) {
                Attachment::create([
                    'post_id' => $form->model()->id,
                    'file_path' => $filePath,
                ]);
            }
        });

        return $form;
    }
}
