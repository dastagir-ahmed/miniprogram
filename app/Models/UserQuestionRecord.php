<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserQuestionRecord
 *
 * @property int $id
 * @property int $user_id 用户id
 * @property int $question_id 试题id
 * @property string $option_ids 用户选择的id，多选用,隔开
 * @property int $iscorrect 是否正确
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereIscorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereOptionIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereUserId($value)
 * @mixin \Eloquent
 * @property string $answers 选择题为用户选择的id，多选用,隔开，单词拼写题为用户拼写的字母
 * @method static \Illuminate\Database\Eloquent\Builder|UserQuestionRecord whereAnswers($value)
 */
class UserQuestionRecord extends Model
{
    protected $table = 'user_question_records';
    use DefaultDatetimeFormat;
}
