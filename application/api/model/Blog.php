<?php
namespace app\api\model;

use think\Model;

class Blog extends Model
{
    public function user()
    {
        return $this->belongsTo('User');
    }
    public function comments()
    {
        return $this->hasMany('Comment');
    }
}
