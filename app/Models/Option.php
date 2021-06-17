<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Option
 *
 * @property int $id
 * @property string $title 试题标题
 * @property int $question_id 对应试题id
 * @property int $iscorrect 是否是正确答案
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereIscorrect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Option extends Model
{
    protected $table = 'options';
    use DefaultDatetimeFormat;
    protected $fillable = ['title','iscorrect'];
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
