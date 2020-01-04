<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/1
 * Time: 9:57
 */

namespace app\api\controller\v1;

use app\api\model\Bike as BikeModel;

use app\api\validate\IsMustBePostiveInt;
use app\lib\exception\BikeException;

class Bike extends Base
{
    /**
     * @return false|\PDOStatement|string|\think\Collection
     * @throws BikeException
     * 获取单车的位置信息
     */
    public function getBicyclePosition() {
        $bikes = BikeModel::getBicyclePosition();
        if(!$bikes) {
           throw new BikeException();
        }
        return $bikes;
    }


    /**
     * @param int $type
     * @param $id
     * @return bool
     * 修改单车的使用状态
     */
    public function updateBikeStatus($type = 0,$id) {
//        (new IsMustBePostiveInt())->goCheck();
        if($type == 0) {
            //锁定单车，单车在被使用中
            $data = [
                'is_show'=>1
            ];
        }elseif ($type == 1) {
            //释放单车，单车恢复使用
            $data = [
                'is_show'=>0
            ];
        }elseif ($type == 2) {
            //单车出现故障
            $data = [
                'type'=>1
            ];
        }elseif ($type == 3) {
            //单车恢复正常
            $data = [
                'type'=>0
            ];
        }

        $res = \app\api\model\Bike::update($data,['id'=>$id]);
        if($res) {
            return true;
        }else {
            echo false;
        }
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws BikeException
     * 根据单车的ID获取单车的信息
     */
    public function getBikeByID($id) {
//        (new IsMustBePostiveInt())->goCheck();
        $bike = BikeModel::getBikeByID($id);
        if(!$bike) {
            throw new BikeException([
                'msg'=>'该车牌号不存在'
            ]);
        }
        if($bike['is_show'] == 1){
            throw new BikeException([
                'msg'=>'此单车正在被使用',
                'errorCode'=>10001
            ]);
        }
        if($bike['type'] == 1) {
            throw new BikeException([
                'msg'=>'此单车多次被报修，暂不可使用',
                'errorCode'=>10002
            ]);
        }
        return $bike;
    }
}