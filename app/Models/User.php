<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username 用户名|input
 * @property string $tel 手机号|input
 * @property string $password 密码|input
 * @property string|null $email 邮箱|input
 * @property int $is_check_email 邮箱验证状态|radio|1:验证通过,2:未验证
 * @property string|null $avatar_url 头像|input
 * @property int $status 状态|radio|1:正常,2:锁定
 * @property int $is_vip vip状态|radio|1:是,2:否
 * @property int $parent_id 推荐人ID|input
 * @property string|null $jpush_id 极光推送注册ID|input
 * @property int $is_subscribe 是否订阅|radio|1:是,2:否
 * @property string $subscribe_email 订阅邮箱|input
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserCoin[] $UserCoin
 * @property-read int|null $user_coin_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserStar[] $UserStar
 * @property-read int|null $user_star_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsCheckEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsSubscribe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsVip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJpushId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSubscribeEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Model
{
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //使用默认时间格式
    use DefaultDatetimeFormat;
    public function UserStar(){
        return $this->hasMany(UserStar::class, 'id', 'uid');
    }
    public function UserCoin(){
        return $this->hasMany(UserCoin::class, 'id', 'uid');
    }
}
