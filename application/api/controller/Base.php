<?php
namespace app\api\controller;
use think\Controller;
use app\api\model\User;
use app\auth\model\Lauth;
use app\auth\model\Oauth;
class Base extends Controller
{
    protected $user = '';
    protected $params = '';
    protected $key = 'you will never guess';
    protected $allow_origin = [
        'http://localhost:8080',
        'http://awesome.com',
        'http://mojienew.com',
        'http://test.mojie.cn.com'
    ];
    protected $admin_list = [
        'user1',
        'user2'
    ];
    
    public function _initialize()
    {  
        //只有跨域请求才会存在 HTTP_ORIGIN
        if( isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $this->allow_origin)) {
            header('Access-Control-Allow-Origin:'.$_SERVER['HTTP_ORIGIN']);
            header('Access-Control-Allow-Method:GET,POST');
            header('Access-Control-Allow-Headers:Content-Type');
            //配置允许发送认证信息 比如cookies（会话机制的前提）
            header('Access-Control-Allow-Credentials: true');
        }
        if (request()->isGet()){
            $this->params = (object)input('get.');
        } else if (request()->isPost()){
            $this->params = file_get_contents("php://input");
            $this->params = json_decode($this->params);
        }
        if (isset($this->params->token)) {
            $this->parse_token();
        }
    }
    
    protected function is_admin()
    {
        if ($this->user == '') {
            return false;
        }
        
        if (in_array($this->user->name,$this->admin_list)) {
            return true;
        } else {
            return false;
        }
    }
    protected function parse_token() {
        $token = explode('-', $this->params->token);
        if ($token[1] == 'lauth') {
            $data = Lauth::get(['username' => $token[0]]);
            $check = md5($data->username.'-'.$data->password);
            if ($check == $token[3]) {
                $this->user = User::get(['id' => $data->user_id]);
            }
        } else if ($token[1] == 'oauth') {
            $data = Oauth::get(['oauth_id' => $token[0]]);
            $check = $data->oauth_access_token.'-'.$data->oauth_expires.'-'.$data->oauth_id;
            if ($check == $token[2]) {
                $this->user = User::get(['id' => $data->user_id]);
            }
        }
    }

    protected function page($item_count, $page_index=1, $page_size=5)
    {
        $page_count = intval(floor($item_count/$page_size));
        if ($item_count % $page_size > 0){
            $page_count = $page_count+1;
        }
        if ($item_count == 0 || $page_index > $page_count){
            $offset = 0;
            $limit = 0;
            $page_index = 1;
        } else {
            $page_index = $page_index;
            $offset = $page_size * ($page_index - 1);
            $limit = $page_size;
        }
        $has_next = $page_index < $page_count;
        $has_previous = $page_index > 1;
        return [
            'item_count' => $item_count,
            'page_index' => $page_index,
            'page_size'  => $page_size,
            'page_count' => $page_count,
            'offset'     => $offset,
            'limit'      => $limit,
            'has_next'   => $has_next,
            'has_previous' => $has_previous,
        ];
    }
}
