<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/12
 * Time: 16:02
 */

namespace app\admin\model;


use think\Model;

class User extends Model
{
    public static function getAllUser() {
        $pagination = config('pagination.user');
        return self::order('create_time','desc')->paginate($pagination['list_row']);
    }
}