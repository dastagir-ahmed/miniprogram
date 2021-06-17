<?php

namespace App\Admin\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FeedbackController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Feedback';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Feedback());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User'))->display(function ($user_id) {
            return User::find($user_id)->username;
        });
        $grid->column('content', __('Content'));
        $grid->column('tel', __('Tel'));
        $grid->column('imgs', __('Img'))->image();
        $grid->column('types', __('Types'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
        });
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
        $show = new Show(Feedback::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User'))->as(function ($user_id) {
            return User::find($user_id)->username;
        });;
        $show->field('content', __('Content'));
        $show->field('tel', __('Tel'));
        $show->field('imgs', __('Imgs'))->image();
        $show->field('types', __('Types'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

}
