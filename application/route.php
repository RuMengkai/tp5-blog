<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

return [

    '[api]' => [
        'login' => 'auth/lauths/login',
        'register' => 'auth/lauths/register',
        'oauth' => 'auth/oauths/login',
        'callback' => 'auth/oauths/callback',
        'user' => 'api/index/user',
        'blogs' => 'api/blogs/blogs',
        'blog' => 'api/blogs/blog',
        'blog_save' => 'api/blogs/blog_save',
        'blog_delete' => 'api/blogs/blog_delete',
        'comments' => 'api/comments/comments',
        'comment_save' => 'api/comments/comment_save'
    ],
    'home' => 'home/index/index',
    'login' => 'home/index/index',
    'register' => 'home/index/index',
    'blog/:id' => 'home/index/index',
    'edit/[:id]' => 'home/index/index',
    
];
