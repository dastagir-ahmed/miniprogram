<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use App\Models\Option;
use App\Models\Question;
use App\Models\Word;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class QuestionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Question management';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Question());

        $grid->column('id', __('Id'));
        $grid->column('title', __('title'))->expand(function ($model) {
            $options = Option::where([['question_id','=',$model->id]])->get()->map(function ($comment) {
                return $comment->only(['id', 'title', 'iscorrect']);
            });
            $options=$options->toArray();
            foreach ($options as $k => $v){
                if ($options[$k]['iscorrect']==1) {
                    $options[$k]['iscorrect'] = "YES";
                } else {
                    $options[$k]['iscorrect'] = "NO";
                }
            }
            return new Table(['ID', 'content', 'Is it correct'], $options);
        });
        $grid->column('word_id', __('word'))->display(function ($word_id){
            return Word::find($word_id)->word;
        });
        $grid->column('type', __('type'))->display(function ($relased) {
            switch ($relased) {
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
            return $relased;
        });
        $grid->column('question_type', __('Topic type'))->display(function ($relased) {
            switch ($relased) {
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
            return $relased;
        });
        $grid->column('created_at', __('Creation time'));
        $grid->column('updated_at', __('Update time'));
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->column(0.5, function ($filter) {
                $filter->like('title', 'subject');
                $filter->like('name', 'chinese');
            });
            $filter->column(0.5, function ($filter) {
                $filter->between('created_at', 'created_at')->datetime();
                $filter->between('updated_at', 'updated_at')->datetime();
            });
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
        $show = new Show(Question::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('word_id', __('words'))->as(function ($word_id){
            return Word::find($word_id)->word;
        });;
        $show->field('title', __('title'));
        $show->field('type', __('type'))->as(function ($relased) {
            switch ($relased) {
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
                    return "Word Spelling";
                    break;
            }
            return $relased;
        });
        $show->field('question_type', __('题目类型'))->as(function ($relased) {
            switch ($relased) {
                case 1:
                    return "Single choice";
                    break;
                case 2:
                    return "Multiple choice";
                    break;
                case 3:
                    return "Word Spelling";
                    break;
            }
            return $relased;
        });
        $show->field('created_at', __('created_at'));
        $show->field('updated_at', __('updated_at'));
        $show->field('deleted_at', __('deleted_at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Question());
        if($form->isCreating()){
            $form->ignore(['course_id']);
            $form->select('course_id', __('课程'))->options(function(){
                $res=Course::get();
                $tmp=[];
                foreach($res as $v){
                    $tmp[$v->id]=$v->title;
                }
                return $tmp;
            })->load('word_id','/api/word/wordadmin');
            $form->select('word_id', __('word'));
        }
        $form->text('title', __('title'));
        $form->select('type', __('type'))
            ->options([1 => 'Inside word', 2 => 'Chinese - English', 3 => 'English - Chinese',4=>'Word Spelling'])
            ->default(1);
        $form->select('question_type', __('question type'))->options([1=>'Single choice',2=>'Multiple choice',3=>'Word Spelling'])->default(1);
        $form->hasMany('options','options', function (Form\NestedForm $form) {
            $form->text('title','title');
            $states = [
                'on'  => ['value' => true, 'text' => 'correct'],
                'off' => ['value' => false, 'text' => 'error'],
            ];
            $form->switch('iscorrect','Is it correct')->states($states);
        });
        return $form;
    }
}
