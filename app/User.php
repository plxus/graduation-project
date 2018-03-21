<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\Repository;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    protected $table = 'users';  // User 用户模型类对应 users 数据表

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
    'name', 'email', 'password', 'bio',
  ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
    'password', 'remember_token',
  ];

    // Gravatar 头像
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "https://cn.gravatar.com/avatar/$hash?s=$size";
    }

    // 指明一个用户可以创建多个知识清单。
    public function repositories()
    {
        return $this->hasMany(Repository::class, 'user_id', 'id');
    }

    // 获取 Feed 信息流数据
    public function feed()
    {
        $feed_user_ids = Auth::user()->followings->pluck('id')->toArray();
        array_push($feed_user_ids, Auth::user()->id);  // 将当前用户的 id 加入到数组中
        return Repository::whereIn('user_id', $feed_user_ids)
        ->with('user')
        ->orderBy('created_at', 'desc');
        // 使用了 Eloquent 关联的预加载 with 方法，预加载避免了 N+1 查找的问题
    }

    // 指明一个用户可以拥有多个关注者。belongsToMany() 方法的第二个参数是关联关系的表名，第三个参数是定义在关联中的模型外键名，第四个参数是要合并的模型外键名。
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id');
    }

    // 指明一个用户可以关注多个用户。
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id');
    }

    // 关注操作。
    public function follow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->sync($user_ids, false);
    }

    // 取消关注操作。
    public function unfollow($user_ids)
    {
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }

    // 判断用户 A 是否关注了用户 B。
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
