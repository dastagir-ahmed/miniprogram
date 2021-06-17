<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('tel', __('Tel'));
        $grid->column('email', __('Email'));
        $grid->column('avatar_url', __('Avatar'))->image();
        $grid->column('status', __('Status'));
        $grid->column('openid', __('Openid'));
        $grid->column('level', __('Level'));
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('username', __('Username'));
        $show->field('tel', __('Tel'));
        $show->field('email', __('Email'));
        $show->field('avatar_url', __('Avatar url'));
        $show->field('openid', __('Openid'));
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
        $form = new Form(new User());

        $form->text('username', __('Username'));
        $form->text('tel', __('Tel'));
        $form->password('password', __('Password'));
        $form->email('email', __('Email'));
        $form->image('avatar_url', __('Avatar url'));
        $form->switch('status', __('Status'))->default(1);
        $form->saving(function (Form $form) {
            $form->subscribe_email = $form->email;
            if ($form->password != $form->model()->password) {
                $form->password = bcrypt($form->password);
            }
        });
        return $form;
    }
}
