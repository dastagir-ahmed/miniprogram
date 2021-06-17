<?php

namespace App\Admin\Controllers;

use App\Models\Column;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ColumnController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Column';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Column());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('code', __('Code'));
        $grid->column('icon', __('Icon'));
        $grid->column('parent_id', __('Parent'))->display(function ($parent_id) {
            $column=Column::find($parent_id);
            if($column){
                return $column->name;
            }
            return "-";
        });
        $grid->column('url', __('Url'));
        $grid->column('description', __('Description'));
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
        $show = new Show(Column::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('code', __('Code'));
        $show->field('icon', __('Icon'));
        $show->field('parent_id', __('Parent'))->as(function ($parent_id) {
            return Column::find($parent_id)->name;
        });
        $show->field('url', __('Url'));
        $show->field('description', __('Description'));
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
        $form = new Form(new Column());
        $ColumnData = (new Column())->getAll();
        $form->text('name', __('Name'));
        $form->text('code', __('Code'));
        $form->text('icon', __('Icon'));
        $form->select('parent_id', __('Parent'))->options($ColumnData);
        $form->url('url', __('Url'));
        $form->textarea('description', __('Description'));

        return $form;
    }
}
