<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/1
 * Time: 15:21
 */

namespace app\api\service;


use app\api\model\User;
use app\lib\exception\WxException;
use think\Exception;

class UserToken extends Token
{
    protected $app_id;

    protected $app_secret;

    protected $wx_login_url;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
        $this->app_id = config('wx.app_id');
        $this->app_secret = config('wx.app_secret');
        $this->wx_login_url = sprintf(config('wx.login_url'),$this->app_id,$this->app_secret,$code);
    }

    public function get() {
        $result = curl_get($this->wx_login_url);
        $result = json_decode($result,true);
        if(!$result) {
            throw new Exception([
                'msg'=>'获取openID失败，微信内部错误'
            ]);
        }else {
            if(array_key_exists('errcode',$result)){
                $this->processLoginError($result);
            }else {
                return $this->grantToken($result);
            }
        }
    }

    /**
     * @param $result
     * @return string
     * 分配token
     */
    public function grantToken($result) {
        $openId = $result['openid'];
        $user = User::getUserByOpenID($openId);
        if($user) {
            $userId = $user->id;
        }else {
            $userId = $this->newUser($openId);
        }
        $user = User::get($userId);
        return $this->saveToCache($user);
    }

    /**
     * @param $user
     * @return string
     * @throws Exception
     * 保存到缓存中
     */
    public function saveToCache($user) {
        $value = json_encode($user);
        $key = $this->generateToken();
        $expire_in = config('setting.token_expire_in');
        $res = cache($key,$value,$expire_in);
        if(!$res) {
            throw new Exception([
                'msg'=>'缓存失败，请查看系统日志'
            ]);
        }
        return $key;
    }

    /**
     * @param $openId
     * @return mixed
     * 创造新的用户
     */
    public function newUser($openId) {
        $user = User::create(['openid'=>$openId]);
        return $user->id;
    }

    /**
     * @param $result
     * @throws WxException
     * 处理微信登录的错误
     */
    public function processLoginError($result) {
        throw new WxException([
            'msg'=>$result['errmsg'],
            'errCode'=>$result['errcode']
        ]);
    }

}