<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleRecommend;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleRecommendController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Article Recommend';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ArticleRecommend());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User'))->display(function ($user_id) {
            return User::find($user_id)->username;
        });
        $grid->column('article_id', __('Article'))->display(function ($article_id) {
            return Article::find($article_id)->title;
        });
        $grid->column('content', __('Content'));
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
        $show = new Show(ArticleRecommend::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User'))->as(function ($user_id) {
            return User::find($user_id)->username;
        });
        $show->field('article_id', __('Article'))->as(function ($article_id) {
            return Article::find($article_id)->title;
        });
        $show->field('content', __('Content'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        return $show;
    }

}
