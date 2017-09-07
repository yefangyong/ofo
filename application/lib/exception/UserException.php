<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/7/1
 * Time: 15:12
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 401;
    public $msg = '用户不存在';
    public $errorCode = 60001;
}