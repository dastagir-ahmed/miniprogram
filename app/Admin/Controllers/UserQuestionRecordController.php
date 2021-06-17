<?php

namespace App\Admin\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use App\Models\UserQuestionRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class UserQuestionRecordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Answer notes';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserQuestionRecord());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('cell-phone number'))->display(function ($user_id) {
            return User::find($user_id)->tel;
        });
        $grid->column('question_id', __('question'))->display(function ($question_id) {
            return Question::find($question_id)->title;
        })->expand(function ($model) {
            $question = Question::find($model->question_id);
            $getOption = Option::where([['question_id', '=', $model->question_id]])->get();
            if ($question->question_type != 3) {
                $options = Option::where([['question_id', '=', $model->question_id]])->get()->map(function ($comment) {
                    return $comment->only(['id', 'title', 'iscorrect']);
                });
                $options=$options->toArray();
                $answerArr = explode(',', $model->answers);
                foreach ($getOption as $k => $v) {
                    if (in_array($getOption[$k]['id'], $answerArr)) {
                        $options[$k]['userAnswer'] = "Yes";
                    } else {
                        $options[$k]['userAnswer'] = "No";
                    }
                }
                foreach ($options as $k => $v){
                    if ($options[$k]['iscorrect']==1) {
                        $options[$k]['iscorrect'] = "Yes";
                    } else {
                        $options[$k]['iscorrect'] = "No";
                    }
                }
                return new Table(['ID', 'content', 'Is it correct', 'User answers'],$options );
            } else {
                return new Table(['User answers'], [$model->answers]);
            }
        });
        $grid->column('type', __('type'))->display(function(){
            $question=Question::find($this->question_id);
            switch ($question->type) {
                case 1:
                    return "Inside word";
                    break;
                case 2:
                    return "Chinese - English";
                    break;
                case 3:
                    return "English - Chinese";
                    break;
                case 4:
                    return "Word Spelling ";
                    break;
            }
            return '';
        });
        $grid->column('question_type', __('question_type'))->display(function () {
            $question=Question::find($this->question_id);
            switch ($question->question_type) {
                case 1:
                    return "Single choice";
                    break;
                case 2:
                    return "Multiple choice";
                    break;
                case 3:
                    return "Word Spelling ";
                    break;
            }
            return '';
        });
        $grid->column('iscorrect', __('Is the answer correct'))->display(function ($relased) {
            switch ($relased) {
                case 1:
                    return "correct";
                    break;
                case 0:
                    return "error";
                    break;
            }
            return $relased;
        });
        $grid->column('created_at', __('created_at'));
        $grid->column('updated_at', __('updated_at'));
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
        $show = new Show(UserQuestionRecord::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('question_id', __('Question id'));
        $show->field('answers', __('Answers'));
        $show->field('iscorrect', __('Iscorrect'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('deleted_at', __('Deleted at'));

        return $show;
    }

}
