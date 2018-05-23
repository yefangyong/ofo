<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/12
 * Time: 14:19
 */

namespace app\admin\controller;

use My\RedisPackage;
use think\cache\driver\Memcached;
use think\Controller;

class Index extends Controller
{
    public function index() {
//        $memcache = new Memcached();
//       session('test','测试');
        return $this->fetch();


    }

    public function welcome() {
        return "欢迎访问享骑单车小程序后台管理系统";
    }
}