<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\Column;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Article';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('keywords', __('Keywords'));
        $grid->column('description', __('Description'))->hide();
        $grid->column('column_id', __('Column'))->display(function ($column_id) {
            return Column::find($column_id)->name;
        });
        $grid->column('isrecommend', __('Is recommend'))->display(function ($relased) {
            return $relased == 1 ? "Yes" : "No";
        });
        $grid->column('iscomment', __('Is comment'))->display(function ($relased) {
            return $relased == 1 ? "Yes" : "No";
        });
        $grid->column('isbottom', __('Is bottom'))->display(function ($relased) {
            return $relased == 1 ? "Yes" : "No";
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->column('img', __('Img'))->image();

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
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('keywords', __('Keywords'));
        $show->field('description', __('Description'));
        $show->field('column_id', __('Column id'))->as(function ($column_id) {
            return Column::find($column_id)->name;
        });
        $show->field('content', __('Content'));
        $show->field('isrecommend', __('Isrecommend'))->as(function ($relased) {
            return $relased == 1 ? "Yes" : "No";
        });
        $show->field('iscomment', __('Iscomment'))->as(function ($relased) {
            return $relased == 1 ? "Yes" : "No";
        });
        $show->field('isbottom', __('Isbottom'))->as(function ($relased) {
            return $relased == 1 ? "Yes" : "No";
        });
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));
        $show->field('img', __('Img'))->image();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());
        $ColumnData=(new Column())->getAll();
        $form->text('title', __('Title'));
        $form->text('keywords', __('Keywords'));
        $form->text('description', __('Description'));
        $form->select('column_id', __('Column'))->options($ColumnData);
        $form->UEditor('content', __('Content'));
        $form->switch('isrecommend', __('Isrecommend'));
        $form->switch('iscomment', __('Iscomment'));
        $form->switch('isbottom', __('Isbottom'));
        $form->image('img', __('Img'));

        return $form;
    }
}
