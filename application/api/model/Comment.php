<?php
namespace app\api\model;

use think\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo('User');
    }
    public function blog()
    {
        return $this->belongsTo('Blog');
    }
}
