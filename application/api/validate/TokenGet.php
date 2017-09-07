<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/6/25
 * Time: 14:17
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code'=>'require|isNotEmpty'
    ];

    protected $message = [
        'code'=>'没有code值还想获取token值做梦哦'
    ];
}