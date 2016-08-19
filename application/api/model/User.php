<?php
namespace app\api\model;

use think\Model;

class User extends Model
{
    public function blogs()
    {
        return $this->hasMany('Blog');
    }
    public function comments()
    {
        return $this->hasMany('Comment');
    }
}
