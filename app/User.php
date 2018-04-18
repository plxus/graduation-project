<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\Repository;
use App\Category;

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
    'role_id', 'is_admin', 'name', 'email', 'avatar', 'password', 'bio', 'url',
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

    // 指明一个用户可以拥有多个关注者。belongsToMany() 方法的第二个参数是关联关系的表名，第三个参数是定义在关联表中的模型外键名，第四个参数是关联表中要合并的关联键名。
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
        return $this->followings->contains($user_id);  // followings 属性返回关注的用户的 Eloquent 集合
    }

    // 指明一个用户可以收藏多个知识清单。
    public function stars()
    {
        return $this->belongsToMany(Repository::class, 'stars', 'user_id', 'repository_id');
    }

    // 收藏操作。
    public function star($repository_ids)
    {
        if (!is_array($repository_ids)) {
            $repository_ids = compact('repository_ids');
        }
        $this->stars()->sync($repository_ids, false);
        // repositories 表中 star_num 字段加 1
        foreach ($repository_ids as $repository_id) {
            $repository_item = Repository::find($repository_id);
            $repository_item->star_num = $repository_item->star_num + 1;
            $repository_item->save();
        }
    }

    // 取消收藏操作。
    public function unstar($repository_ids)
    {
        if (!is_array($repository_ids)) {
            $repository_ids = compact('repository_ids');
        }
        $this->stars()->detach($repository_ids);
        // repositories 表中 star_num 字段减 1
        foreach ($repository_ids as $repository_id) {
            $repository_item = Repository::find($repository_id);
            $repository_item->star_num = $repository_item->star_num - 1;
            $repository_item->save();
        }
    }

    // 判断用户是否收藏了某知识清单。
    public function isStar($repository_id)
    {
        return $this->stars->contains($repository_id);  // stars 属性返回关注的用户的 Eloquent 集合
    }

    // 指明一个用户可以有多个偏好的知识清单类别
    public function preferred_categories()
    {
      return $this->belongsToMany(Category::class, 'preferred_categories', 'user_id', 'category_id');
    }
}
