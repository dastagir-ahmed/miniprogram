<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Activity';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Activity());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('cover', __('Cover'))->image();
        $grid->column('img', __('Img'))->image();
        $grid->column('starttime', __('Starttime'));
        $grid->column('endtime', __('Endtime'));
        $grid->column('sign_endtime', __('Sign endtime'));
        $grid->column('zubie', __('Group'));
        $grid->column('guize', __('Rule'));
        $grid->column('xize', __('Detail'));
        $grid->column('created_at', __('created_at'));
        $grid->column('updated_at', __('updated_at'));
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
        $show = new Show(Activity::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('cover', __('Cover'))->image();
        $show->field('img', __('Img'))->image();
        $show->field('starttime', __('Starttime'));
        $show->field('endtime', __('Endtime'));
        $show->field('sign_endtime', __('Sign endtime'));
        $show->field('zubie', __('Group'));
        $show->field('guize', __('Rule'));
        $show->field('xize', __('Detail'));
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
        $form = new Form(new Activity());

        $form->text('title', __('Title'));
        $form->image('cover', __('Cover'));
        $form->image('img', __('Img'));
        $form->datetime('starttime', __('Starttime'))->default(date('Y-m-d H:i:s'));
        $form->datetime('endtime', __('Endtime'))->default(date('Y-m-d H:i:s'));
        $form->datetime('sign_endtime', __('Sign endtime'))->default(date('Y-m-d H:i:s'));
        $form->text('zubie', __('Group'));
        $form->text('guize', __('Rule'));
        $form->text('xize', __('Detail'));

        return $form;
    }
}
