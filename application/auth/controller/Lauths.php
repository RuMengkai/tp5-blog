<?php
namespace app\auth\controller;

use app\api\controller\Base;
//use think\Controller;
use think\Db;
use app\auth\model\Lauth;
use app\api\model\User;

class Lauths extends Base
{
    public function login()
    {
        if (request()->isPost()) {
            $user = Lauth::get(['username' => $this->params->username]);
            if ($user == '') {
                return json(['error' => '没有该用户']);
            }
            if ($this->params->password == $user->password) {
                $username = $user->username;
                $auth = 'lauth';
                $expire = time() + 3600*24*7;
                $token = $user->username.'-'.$user->password;
                $cookie = $username.'-'.$auth.'-'.$expire.'-'.md5($token);
                return json([
                    'success' => '登录成功', 
                    'cookie' => $cookie, 
                    'expire' => $expire*1000,
                    'user'  => User::get($user->user_id)
                ]);
                //return $this->success('登陆成功', '/home');
            } else {
                //return $this->error('用户名或密码错误');
                return json(['error' => '用户名或密码错误']);
            }
        }
    }
    public function register()
    {
        if (request()->isPost()) {
            $user = Lauth::get(['username' => $this->params->username]);
            if ($user) {
                return $this->error('该用户已注册');
            }
            //$user = ['nickname' => $username];
            Db::startTrans();
            try {
                //Db::table('user')->insert($user);
                $user = new User;
                $user->nickname = $this->params->username;
                $user->image = 'http://awesome.com/static/images/user.png';
                $user->save();
                $user_id = User::get(['nickname' => $this->params->username])->id;
                //$data = ['user_id' => $user_id, 'username' => $username, 'password' => $password];
                $lauth = new Lauth;
                $lauth->user_id = $user_id;
                $lauth->username = $this->params->username;
                $lauth->password = $this->params->password;
                $lauth->save();
                //Db::table('lauth')->insert($data);
                // 提交事务
                Db::commit();
            } catch (\PDOException $e) {
                // 回滚事务
                Db::rollback();
            }
            $result = Lauth::get(['username' => $this->params->username]);
            if ($result) {
                $username = $result->username;
                $auth = 'lauth';
                $expire = time() + 3600*24*7;
                $token = $result->username.'-'.$result->password;
                $cookie = $username.'-'.$auth.'-'.$expire.'-'.md5($token);
                return json([
                    'success' => '注册成功', 
                    'cookie' => $cookie, 
                    'expire' => $expire*1000,
                    'user'  => User::get($result->user_id)
                ]);
            } else {
                return json(['error' => '注册失败']);
            }
        }
    }

}
