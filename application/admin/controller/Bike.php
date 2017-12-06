<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/12
 * Time: 17:31
 */

namespace app\admin\controller;


use think\Controller;

class Bike extends Controller
{
    public function index() {
        $bikes = \app\admin\model\Bike::getAllBike();
        return $this->fetch('',['bike'=>$bikes]);
    }

    public function add() {
        if($_POST) {
            $passwd = $_POST['password'];
            $address = $_POST['address'];
            if(empty($passwd) || empty($address)) {
                return show(0,'请填写密码或者地址');
            }
            $result = \TxMap::getLngLat($address);
            $lat = $result['result']['location']['lat'];
            $lng = $result['result']['location']['lng'];
            $data = [
                'latitude'=>$lat,
                'longitude'=>$lng,
                'is_show'=>0,
                'type'=>0,
                'password'=>$passwd
            ];
            $res = \app\admin\model\Bike::create($data);
            if($res) {
                return show(1,'添加成功');
            }else {
                return show(0,'添加失败');
            }
        }else {

            return $this->fetch();
        }

    }
}