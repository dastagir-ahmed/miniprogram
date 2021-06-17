<?php

namespace App\Admin\Controllers;

use App\Models\Forum;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ForumController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Forum';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Forum());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('content', __('Content'));
        $grid->column('imgs', __('Imgs'));
        $grid->column('istop', __('Is top'))->display(function ($relased) {
            switch ($relased) {
                case 1:
                    return "Yes";
                    break;
                case 2:
                    return "No";
                    break;
            }
            return $relased;
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
        $show = new Show(Forum::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('imgs', __('Imgs'));
        $show->field('istop', __('Istop'));
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
        $form = new Form(new Forum());

        $form->text('title', __('Title'));
        $form->UEditor('content', __('Content'));
        $form->image('imgs', __('Imgs'));
        $form->switch('istop', __('Is top'));

        return $form;
    }
}
