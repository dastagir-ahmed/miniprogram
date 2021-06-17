<?php
namespace App\Models;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 *
 * @property int $id id
 * @property string|null $title 标题
 * @property string|null $keywords 关键词
 * @property string|null $description 描述
 * @property int $type_id 分类ID
 * @property string|null $article_content 内容
 * @property \Illuminate\Support\Carbon|null $created_at 创建时间
 * @property \Illuminate\Support\Carbon|null $updated_at 更新时间
 * @property string|null $deleted_at 删除时间
 * @property string|null $img 缩略图
 * @property-read \App\Models\ArticleType|null $ArticleType
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereArticleContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    //使用默认时间格式
    use DefaultDatetimeFormat;
    //此处填写表名
    protected $table = 'articles';
    // 通过 class_id 与 cms_class 的 id 进行关联
    public function ArticleType(){
        return $this->hasOne(ArticleType::class, 'id', 'type_id');
    }
}

//php artisan admin:make ArticleController --model=App\Model\Article