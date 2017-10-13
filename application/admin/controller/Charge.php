<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/13
 * Time: 10:08
 */

namespace app\admin\controller;


use think\Controller;

class Charge extends Controller
{
    public function index() {
        $charge =  \app\admin\model\Charge::getAllCharge();
        return $this->fetch('',['charge'=>$charge]);
    }
}