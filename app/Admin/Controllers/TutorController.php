<?php

namespace App\Admin\Controllers;

use App\Models\Tutor;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TutorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Tutor';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tutor());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('name', __('Name'));
        $grid->column('sex', __('Sex'));
        $grid->column('age', __('Age'));
        $grid->column('tel', __('Tel'));
        $grid->column('city', __('City'));
        $grid->column('company', __('Company'));
        $grid->column('job', __('Job'));
        $grid->column('time', __('Time'));
        $grid->column('remark', __('Remark'));
        $grid->column('ispass', __('Ispass'));
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
        $show = new Show(Tutor::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('name', __('Name'));
        $show->field('sex', __('Sex'));
        $show->field('age', __('Age'));
        $show->field('tel', __('Tel'));
        $show->field('city', __('City'));
        $show->field('company', __('Company'));
        $show->field('job', __('Job'));
        $show->field('time', __('Time'));
        $show->field('remark', __('Remark'));
        $show->field('ispass', __('Ispass'));
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
        $form = new Form(new Tutor());

        $form->number('user_id', __('User id'));
        $form->text('name', __('Name'));
        $form->number('sex', __('Sex'));
        $form->number('age', __('Age'));
        $form->text('tel', __('Tel'));
        $form->text('city', __('City'));
        $form->text('company', __('Company'));
        $form->text('job', __('Job'));
        $form->text('time', __('Time'));
        $form->text('remark', __('Remark'));
        $form->number('ispass', __('Ispass'))->default(1);

        return $form;
    }
}
