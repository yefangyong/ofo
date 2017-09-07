<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/1
 * Time: 15:39
 */

namespace app\api\model;


class User extends Base
{
    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * 根据openid获取用户的信息
     */
    public static function getUserByOpenID($id){
        $data = [
            'openid'=>$id
        ];
        return self::where($data)->find();
    }

    /**
     * @param $id
     * @param $guarantee
     * @return $this
     * 修改保证金的金额
     */
    public static function updateGuarantee($id,$guarantee) {
        $data = [
            'guarantee'=>$guarantee
        ];
        return self::update($data,['id'=>$id]);
    }
}