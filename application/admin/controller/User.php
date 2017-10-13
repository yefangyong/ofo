<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/12
 * Time: 15:26
 */

namespace app\admin\controller;


use think\Controller;

class User extends Controller
{
    public function index() {
        $user = \app\admin\model\User::getAllUser();
        return $this->fetch('',['user'=>$user]);
    }
}