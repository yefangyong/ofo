<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/28
 * Time: 22:29
 */

namespace app\api\validate;


use think\Validate;

class IsMustBePostiveInt extends BaseValidate
{
    protected $rule = [
        'id'=>'require|isPostiveInt',
    ];

    protected $message = [
        'id'=>'id必须是正整数'
    ];




}