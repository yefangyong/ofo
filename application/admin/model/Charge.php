<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/13
 * Time: 10:18
 */

namespace app\admin\model;


use think\Model;

class Charge extends Model
{
    /**
     * @param $value
     * @param $data
     * @return string
     * 改变获取到数据的属性值
     */
    public function getTypeAttr($value,$data) {
        if($value == 0) {
            return $value ='押金充值';
        }else {
            return $value = '余额充值';
        }
    }
    /**
     * @return \think\model\relation\BelongsTo
     * 关联用户表 多对一关联
     */
    public function user(){
        return $this->belongsTo('User','user_id');
    }

    /**
     * @return \think\Paginator
     * 获取所有的充值记录
     */
    public static function getAllCharge() {
        return self::order('create_time','desc')->with('user')->paginate(config('pagination.list_rows'));
    }
}