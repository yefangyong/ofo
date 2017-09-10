<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/8
 * Time: 13:15
 */

namespace app\api\controller\v1;


class TroubleCate extends Base
{
    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取问题的分类信息
     */
    public function getTroubleCate() {
        $res = new \app\api\model\TroubleCate();
        $troubleCate = $res->select();
        return $troubleCate;
    }
}