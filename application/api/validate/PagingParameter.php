<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/7/15
 * Time: 18:35
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
        'page'=>'require|isPostiveInt',
        'size'=>'isPostiveInt'
    ];

    protected $message = [
        'page'=>'分页参数必须是正整数',
        'size'=>'分页参数必须是正整数'
    ];
}