<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/1
 * Time: 9:59
 */
namespace app\api\model;
use think\Model;

class Bike extends Model
{


    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取单车的位置信息
     */
    public static function getBicyclePosition() {
        $data = [
            'is_show'=>0,
            'type'=>0
        ];
        return self::where($data)->select();
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|Model
     * 获取根据ID获取单车的密码
     */
    public static function getBikeByID($id) {
        $data = [
            'id'=>$id
        ];
        return self::where($data)->find();
    }
}