<?php
namespace app\auth\controller;

use think\Controller;
use app\auth\oauthsdk\TypeEvent;
use app\auth\oauthsdk\ThinkOauth;
use think\Db;
use app\auth\model\Oauth;
use app\api\model\User;

class Oauths extends Controller
{
    
	//登录地址
	public function login($type = null){
		empty($type) && $this->error('参数错误');

		$sns  = ThinkOauth::getInstance($type);

		//跳转到授权页面
		$this->redirect($sns->getRequestCodeURL());
	}

	//授权回调地址
	public function callback($state, $type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('参数错误');
		if ($state != session('state')) {
		    return $this->error('state不对');
		}
		session('state', null);
		$sns  = ThinkOauth::getInstance($type);

		//腾讯微博需传递的额外参数
		$extend = null;
		if($type == 'tencent'){
			$extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
		}

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend);
		
		$event = new TypeEvent;
		$user_info = $event->$type($token);
        $oauth_id = $type.'_'.$token['openid'];
        $oauth = Oauth::get(['oauth_id' => $oauth_id]);
        if ($oauth) {
            $oauth->oauth_access_token = $token['access_token'];
            $oauth->oauth_expires = $token['expires_in'];
        } else {
            Db::startTrans();
            try {
                $user = new User;
                $user->nickname = $user_info['name'];
                $user->save();
                $user_id = User::get(['nickname' => $user_info['name']])->id;
                $oauth = new Oauth;
                $oauth->user_id = $user_id;
                $oauth->oauth_access_token = $token['access_token'];
                $oauth->oauth_expires = $token['expires_in'];
                $oauth->oauth_name = $type;
                $oauth->oauth_id = $oauth_id;
                $oauth->save();
                // 提交事务
                Db::commit();
            } catch (\PDOException $e) {
                // 回滚事务
                Db::rollback();
            }
            $result = Oauth::get(['oauth_id' => $oauth_id]);
            if ($result) {
                $username = $result->username;
                $auth = 'Oauth';
                $expire = time() + 3600*24*7;
                $token = $result->oauth_access_token.'-'.$result->oauth_expires.'-'.$result->oauth_id;
                $cookie = $username.'-'.$auth.'-'.$expire.'-'.md5($token);
                return json([
                    'success' => '注册成功', 
                    'cookie' => $cookie, 
                    'expire' => $expire*1000,
                    'user'  => User::get($result->user_id)
                ]);
            } else {
                return $this->error('注册失败');
            }
        }
	}
}
