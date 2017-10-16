<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/13
 * Time: 13:31
 */

namespace app\admin\model;


use think\Model;

class TroubleRecord extends Model
{
    /**
     * @return \think\model\relation\BelongsToMany
     * 关联troubleCate表，多对多关联
     */
    public function troubleCate() {
        return $this->belongsToMany('troubleCate','bike_trouble','trouble_id','record_id');
    }


    /**
     * @return \think\model\relation\BelongsTo
     * 关联用户表
     */
    public function user() {
        return $this->belongsTo('user','user_id');
    }

    /**
     * @return $this
     * 获取所有的故障列表
     */
    public static function getAllTrouble(){
        return self::order('create_time','desc')->with(['troubleCate','user','troubleCate'])->paginate(config('pagination.list_rows'))->each(function($item,$key){
            $lnt = $item->latitude;
            $lgt = $item->longitude;
            $result = \TxMap::getAddress($lgt,$lnt);
            if($result['status'] != 0) {
                $item->address = '' ;
            }else {
                $item->address = $result['result']['formatted_addresses']['recommend'];
            }
            return $item;
        });
    }
}