<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/1
 * Time: 15:22
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    /**
     * @return string
     * 生成token
     */
    public function generateToken() {
        $time = $_SERVER['REQUEST_TIME'];
        $prefix = config('secure.prefix');
        $str = getRandChars(32);
        return md5($time.$prefix.$str);
    }


    /**
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     * 根据变量获取缓存token里面的内容，例如：uid，openid,session_key
     */
    public static function getCurrentTokenVar($key) {
        //获取token
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if(!$vars) {
            throw new TokenException();
        }else {
            if(!is_array($vars)) {
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)) {
                return $vars[$key];
            }else {
                throw new Exception(['尝试获取token的变量不存在']);
            }
        }
    }
    public static function getCurrentUid() {
        $uid = self::getCurrentTokenVar('id');
        return $uid;
    }


}