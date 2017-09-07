<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 15:46
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //http状态码
    public $code = 400;

    //错误信息
    public $msg = '参数错误';

    //错误码
    public $errorCode = 40000;

    /**
     * BaseException constructor.
     * @param array $param
     * 构造函数
     */
    public function __construct($param = [])
    {
        if(!is_array($param)) {
            return  ;
        }
        if(array_key_exists('code',$param)) {
            $this->code = $param['code'];
        }
        if(array_key_exists('msg',$param)) {
            $this->msg = $param['msg'];
        }
        if(array_key_exists('errorCode',$param)) {
            $this->errorCode= $param['errorCode'];
        }
    }
}