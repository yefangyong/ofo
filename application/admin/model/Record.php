<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/13
 * Time: 10:58
 */

namespace app\admin\model;




use think\Model;

class Record extends Model
{
    /**
     * @return \think\model\relation\BelongsTo
     * 关联单车表
     */
    public function bike() {
        return $this->belongsTo('bike','bike_id');
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
     * 获取所有的记录
     */
    public static function getAllRecord() {
        return self::order('create_time','desc')->with(['bike','user'])->paginate(config('pagination.list_rows'))->each(function($item,$key){
            $slnt = $item->start_lati;
            $slgt = $item->start_long;
            $sresult =  \TxMap::getAddress($slgt,$slnt);
            if($sresult['status'] !=0) {
                $item->start_address = '' ;
            }else {
                $item->start_address = $sresult['result']['formatted_addresses']['recommend'];
            }
            $elnt = $item->end_lati;
            $elgt = $item->end_long;
            $eresult = \TxMap::getAddress($elgt,$elnt);
            if($eresult['status'] !=0) {
                $item->end_address = '' ;
            }else {
                $item->end_address = $eresult['result']['formatted_addresses']['recommend'];
            }
            return $item;
            });
    }
}