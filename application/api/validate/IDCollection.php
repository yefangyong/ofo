<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/6/21
 * Time: 22:57
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids'=>'require|checkIDs'
    ];

    protected $message = [
        'ids'=>'ids是以逗号分隔的正整数'
    ];

    protected function checkIDs($value) {
        $values = explode(',',$value);
        if(empty($values)) {
            return false;
        }
        foreach ($values as $id) {
            if(!$this->isPostiveInt($id)) {
                return false;
            }
        }
        return true;
    }

}