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
     * @param $id
     * 修改单车的使用状态
     */
    public function updateBikeStatus($id) {
        (new IsMustBePostiveInt())->goCheck();
        $data = [
            'is_show'=>1
        ];
        $res = \app\api\model\Bike::update($data,['id'=>$id]);
        if($res) {
            echo 'success';
        }else {
            echo 'error';
        }
    }

    /**
     * @param $id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws BikeException
     * 根据单车的ID获取单车的信息
     */
    public function getBikeByID($id) {
        (new IsMustBePostiveInt())->goCheck();
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