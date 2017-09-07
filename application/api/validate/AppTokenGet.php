<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/8/6
 * Time: 19:21
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac'=>"require",
        'se'=>'require'
    ];
}