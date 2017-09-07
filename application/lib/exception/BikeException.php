<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/1
 * Time: 10:21
 */

namespace app\lib\exception;


class BikeException extends BaseException
{
    public $code = 401;

    public $msg = '单车不存在';

    public $errorCode = 10000;
}