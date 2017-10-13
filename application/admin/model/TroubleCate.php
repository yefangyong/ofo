<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/13
 * Time: 11:59
 */

namespace app\admin\model;


use think\Model;

class TroubleCate extends Model
{
    /**
     * @return \think\Paginator
     * 获取故障分类
     */
    public static function getTroubleCate() {
        return self::order('create_time','desc')->paginate(config('pagination.list_rows'));
    }
}