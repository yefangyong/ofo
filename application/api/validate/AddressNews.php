<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/7/1
 * Time: 14:29
 */

namespace app\api\validate;


class AddressNews extends BaseValidate
{
    protected $rule = [
        'name'=>'require|isNotEmpty',
        'mobile'=>'require',
        'city'=>'require|isNotEmpty',
        'country'=>'require|isNotEmpty',
        'detail'=>'require|isNotEmpty',
        'province'=>'require|isNotEmpty',
    ];
}