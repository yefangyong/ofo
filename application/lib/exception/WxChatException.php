<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/6/26
 * Time: 23:49
 */

namespace app\lib\exception;


class WxChatException extends BaseException
{
    public $code = 400;
    public $errorCode = 50000;
    public $msg = '微信内部错误';
}