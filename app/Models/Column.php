<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{

    //使用默认时间格式
    use DefaultDatetimeFormat;

    //此处填写表名
    protected $table = 'columns';

    //增加select返回数据接口
    public function getAll()
    {
        $res = $this->get();
        $tmp = [];
        foreach ($res as $v) {
            $tmp[$v->id] = $v->name;
        }
        return $tmp;
    }
}
