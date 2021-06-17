<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleCommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Article Comment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ArticleComment());

        $grid->column('id', __('Id'));
        $grid->column('article_id', __('Article'))->display(function ($article_id) {
            return Article::find($article_id)->title;
        });
        $grid->column('content', __('Content'));
        $grid->column('parent_id', __('Parent id'))->hide();
        $grid->column('user_id', __('User'))->display(function ($user_id) {
            return User::find($user_id)->username;
        });
        $grid->column('isgood', __('Is good'))->display(function ($relased) {
            return $relased == 1 ? "Yes" : "No";
        });
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
        $show = new Show(ArticleComment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('article_id', __('Article'))->as(function ($article_id) {
            return Article::find($article_id)->title;
        });
        $show->field('content', __('Content'));
        $show->field('user_id', __('User'))->display(function ($user_id) {
            return User::find($user_id)->username;
        });
        $show->field('isgood', __('Is good'))->as(function ($relased) {
            return $relased == 1 ? "Yes" : "No";
        });
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
        $form = new Form(new ArticleComment());
        $form->switch('isgood', __('Isgood'));

        return $form;
    }
}
