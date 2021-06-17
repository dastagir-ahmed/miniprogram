<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

class ArticleRecord extends Model
{
    //使用默认时间格式
    use DefaultDatetimeFormat;
    //此处填写表名
    protected $table = 'article_records';
}
