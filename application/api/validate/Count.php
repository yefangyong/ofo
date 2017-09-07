<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/6/23
 * Time: 20:29
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count'=>'isPostiveInt|between:1,15'
    ];
}