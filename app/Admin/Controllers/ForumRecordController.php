<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\Forum;
use App\Models\ForumRecord;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ForumRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Forum Record';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ForumRecord());

        $grid->column('id', __('Id'));
        $grid->column('forum_id', __('Forum'))->display(function ($forum_id) {
            return Forum::find($forum_id)->title;
        });
        $grid->column('user_id', __('User'))->display(function ($user_id) {
            return User::find($user_id)->username;
        });
        $grid->column('type', __('Type'))->display(function ($relased) {
            switch ($relased) {
                case 1:
                    return "Visit";
                case 2:
                    return "Like";
            }
            return $relased;
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->disableCreateButton();
        $grid->disableActions();
        return $grid;
    }
}
