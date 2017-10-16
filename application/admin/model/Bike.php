<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/12
 * Time: 17:31
 */

namespace app\admin\model;


use think\Model;

class Bike extends Model
{
    public static function getAllBike() {
        return self::order('create_time','desc')->paginate(config('pagination.list_rows'))->each(function ($item, $key){
            $lnt = $item->latitude;
            $lgt = $item->longitude;
            $result = \TxMap::getAddress($lgt,$lnt);
            $item->address = $result['result']['formatted_addresses']['recommend'];
            return $item;
        });
    }
}