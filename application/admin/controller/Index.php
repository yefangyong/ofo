<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/12
 * Time: 14:19
 */

namespace app\admin\controller;


use think\Controller;

class Index extends Controller
{
    public function index() {
       return $this->fetch();
    }

    public function welcome() {
        return "欢迎访问享骑单车小程序后台管理系统";
    }
}