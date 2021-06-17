<?php

namespace App\Admin\Controllers;

use App\Models\UserMessage;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserMessageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserMessage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserMessage());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('content', __('Content'));
        $grid->column('isread', __('Isread'));
        $grid->column('type', __('Type'));
        $grid->column('from_user_id', __('From user id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));

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
        $show = new Show(UserMessage::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('content', __('Content'));
        $show->field('isread', __('Isread'));
        $show->field('type', __('Type'));
        $show->field('from_user_id', __('From user id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserMessage());

        $form->number('user_id', __('User id'));
        $form->text('content', __('Content'));
        $form->switch('isread', __('Isread'));
        $form->number('type', __('Type'));
        $form->number('from_user_id', __('From user id'));

        return $form;
    }
}
