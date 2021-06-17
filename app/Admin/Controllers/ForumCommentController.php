<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ForumCommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ForumComment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ForumComment());

        $grid->column('id', __('Id'));
        $grid->column('forum_id', __('Forum'))->display(function ($forum_id) {
            return Forum::find($forum_id)->title;
        });
        $grid->column('content', __('Content'));
        $grid->column('parent_id', __('Parent id'))->hide();
        $grid->column('user_id', __('User'))->display(function ($user_id) {
            return User::find($user_id)->username;
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->disableCreateButton();
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
        $show = new Show(ForumComment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('forum_id', __('Forum'))->as(function ($forum_id) {
            return Forum::find($forum_id)->title;
        });
        $show->field('content', __('Content'));
        $show->field('user_id', __('User'))->as(function ($user_id) {
            return User::find($user_id)->username;
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

}
