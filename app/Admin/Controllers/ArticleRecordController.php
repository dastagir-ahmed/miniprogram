<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleRecord;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Article Record';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ArticleRecord());

        $grid->column('id', __('Id'));
        $grid->column('article_id', __('Article'))->display(function ($article_id) {
            return Article::find($article_id)->title;
        });
        $grid->column('user_id', __('User'))->display(function ($user_id) {
            return User::find($user_id)->username;
        });
        $grid->column('type', __('Type'))->display(function ($relased) {
            switch ($relased) {
                case 1:
                    return "Visit";
                    break;
                case 2:
                    return "Like";
                    break;
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
