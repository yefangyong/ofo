<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/13
 * Time: 11:58
 */

namespace app\admin\controller;



use app\admin\model\TroubleCate;
use app\admin\model\TroubleRecord;
use think\Controller;

class Trouble extends Base
{
    public $model = 'trouble_record';
    /**
     * @return mixed
     * 故障列表
     */
    public function index() {
        $troubles = TroubleRecord::getAllTrouble();
        $reason = '';
       foreach ($troubles as $key=>$val) {
          foreach ($val['trouble_cate'] as $value) {
              $reason .= ','.$value['name'];
          }
          $reason = substr($reason,1);
          $troubles[$key]['reason'] = $reason;
       }
       return $this->fetch('',['trouble'=>$troubles]);
    }

    /**
     * @return mixed
     * 故障分类列表
     */
    public function troubleCate() {
        $result = TroubleCate::getTroubleCate();
        return $this->fetch('',['troubleCate'=>$result]);
    }

    /**
     * @return mixed|void
     * 分类添加
     */
    public function add(){
        if($_POST) {
            if(empty($_POST['catename'])) {
                return show(0,'请输入分类名称');
            }else {
                $data = [
                    'name'=>$_POST['catename'],
                ];
                $res = TroubleCate::create($data);
                if($res) {
                    return show(1,'添加成功');
                }else {
                    return show(0,'添加失败');
                }
            }
        }else{
            return $this->fetch();
        }
    }
}