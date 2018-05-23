<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/13
 * Time: 10:58
 */

namespace app\admin\controller;

use think\Controller;

class Record extends Controller
{
    /**
     * @return mixed
     * 获取骑行记录
     */
    public function index() {
        $records = \app\admin\model\Record::getAllRecord();
        return $this->fetch('',['records'=>$records]);
    }
}