<?php
namespace app\api\controller;

class Index extends Base
{
    public function user() {
        return json(['user'=> $this->user]);
    }
}
