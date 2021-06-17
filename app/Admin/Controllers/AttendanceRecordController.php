<?php

namespace App\Admin\Controllers;

use App\Models\AttendanceRecord;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AttendanceRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Attendance Record';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AttendanceRecord());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'))->display(function ($user_id) {
            return User::find($user_id)->username;
        });
        $grid->column('type', __('Type'))->display(function ($relased) {
            switch ($relased) {
                case 1:
                    return "Sign in to work";
                case 2:
                    return "Sign in after get off work";
                case 3:
                    return "Overtime sign in";
                case 4:
                    return "Overtime check out";
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
