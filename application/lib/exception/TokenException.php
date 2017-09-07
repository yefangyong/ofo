<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/6/29
 * Time: 11:34
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $errorCode = 10001;
    public $msg = 'token已过期或者无效toekn';
}