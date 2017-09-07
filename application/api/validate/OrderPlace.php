<?php
/**
 * Created by PhpStorm.
 * User: 12810
 * Date: 2017/7/2
 * Time: 9:56
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends  BaseValidate
{
    protected $rule = [
        'products'=>'checkProducts'
    ];

    protected $singleRule = [
        'product_id'=>'require|isPostiveInt',
        'count'=>'require|isPostiveInt'
    ];

    public function checkProducts($values) {
        if(!is_array($values)) {
            throw new ParameterException([
                'msg'=>'参数不合法'
            ]);
        }
        if(empty($values)) {
            throw new ParameterException([
                'msg'=>'商品列表不能为空'
            ]);
        }
        foreach($values as $value) {
            $this->checkProduct($value);
        }
        return true;
    }

    public function checkProduct($value) {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if(!$result) {
            throw new ParameterException([
                'msg'=>'商品列表参数错误'
            ]);
        }
    }
}