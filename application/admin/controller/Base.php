<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/12/14
 * Time: 10:29
 */

namespace app\admin\controller;


use think\Controller;
use think\Exception;

class Base extends Controller
{
    public $model;

    /**
     * @return string
     * 公用的修改状态和删除的方法
     */
    public function status() {
        $params = request()->param();
        if(!intval($params['id'])){
            return show(0,'id不合法');
        }
        //获取当前控制器的名字，一般控制器名字和model和数据表名字一直，如果不一致，我们可以在model里面，直接声明model
        //例如 $this->model = 'model名'
        $model = $this->model?$this->model:request()->controller();

        try {
            $res = model($model)->save(['status'=>$params['status']],['id'=>$params['id']]);
        }catch (Exception $e) {
            return show(0,$e->getMessage());
        }
        $trouble = model($model)->get($params['id']);
        if(isset($trouble->bike_id ) && $trouble->bike_id != 0 ) {
            try {
                $rel = model('Bike')->save(['type'=>0],['id'=>$trouble->bike_id ]);
            }catch (Exception $e) {
                return show(0,$e->getMessage());
            }
        }
        if($res) {
            return show(1,'操作成功');
        }else {
            return show(0,'操作失败');
        }
    }
}