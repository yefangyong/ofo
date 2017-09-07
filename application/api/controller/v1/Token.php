<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/1
 * Time: 15:19
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;
use app\lib\exception\TokenException;
use think\Cache;
use think\Request;

class Token extends Base
{
    /**
     * @param $code
     * @return array
     * 获取token
     */
    public function getToken($code) {
        (new TokenGet())->goCheck();
        $user = new UserToken($code);
        $token = $user->get();
        return [
            'token'=>$token
        ];
    }

    /**
     * @return bool
     * @throws TokenException
     * 验证token
     */
    public function verifyToken() {
        $token = Request::instance()->header('token');
        $var = Cache::get($token);
        if(!$var) {
            throw new TokenException([
                'msg'=>'token已经过期',
                'errorCode'=>10002
            ]);
        }
        return true;
    }
}