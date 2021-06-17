<?php

namespace App\Admin\Controllers;

use App\Models\Activity;
use App\Models\ActivityRecord;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ActivityRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ActivityRecord';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ActivityRecord());

        $grid->column('id', __('Id'));
        $grid->column('activity_id', __('Activity'))->display(function($activity_id){
            return Activity::find($activity_id)->title;
        });
        $grid->column('user_id', __('user'))->display(function($user_id){
            return User::find($user_id)->username;
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->column('deleted_at', __('Deleted at'));
        $grid->disableCreateButton();
        $grid->disableActions();
        return $grid;
    }


}
