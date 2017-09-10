<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/8
 * Time: 11:21
 */

namespace app\api\controller\v1;


use app\api\model\BikeTrouble;
use app\lib\exception\BikeException;
use think\Db;
use think\Exception;

class TroubleRecord extends Base
{
    public function recordTrouble($record) {
        //分为两种情况，车牌损坏，车牌未损坏
       //如果有车牌号码，先判断单车是否存在，不存在，抛出异常，
        //如果存在，写到trouble_record表，根据trouble_record
        //的id，还有trouble_id写到bike_trouble表，多对多表，全部写入成功之后，
        //修改bike表的type值，用到事务，要么失败，要么成功
        $bikeID = $record['inputValue']['num'];
        //2代表车牌被损坏，看不到车牌号码
        if(!in_array(2,$record['checkboxValue'])) {
            if($bikeID) {
                $bike = new Bike();
                $bike->getBikeByID($bikeID);
            }else {
                throw new BikeException([
                    'msg'=>'请输入单车编号',
                    'errorCode'=>10003
                ]);
            }
        }
        try {
            Db::startTrans();
            $address = $record['address'];
            $uid = \app\api\service\Token::getCurrentUid();
            $troubleRecord = new \app\api\model\TroubleRecord();
            $troubleRecord->user_id=$uid;
            $troubleRecord->bike_id=$bikeID;
            $troubleRecord->longitude=$address['start_long'];
            $troubleRecord->latitude=$address['start_lati'];
            $troubleRecord->img=json_encode($record['picUrls']);
            $troubleRecord->remark=$record['inputValue']['desc'];
            //更新故障记录表troubleRecord
            $troubleRecord->save();

            $resID = $troubleRecord->id;


            $troublesID = $record['checkboxValue'];
            $newArr = array();
            foreach ($troublesID as $k=>$v) {
                $newArr[$k]['trouble_id'] = $v;
                $newArr[$k]['record_id'] = $resID;
            }
            $bikeTrouble = new BikeTrouble();
            //更新故障表bikeTrouble表
            $rel = $bikeTrouble->saveAll($newArr);

            if($bikeID) {
                //修改单车的状态，发送了故障
                $bike = new Bike();
                $bike->updateBikeStatus(2,$bikeID);
            }
            if($resID && $rel) {
                Db::commit();
            }
        }catch (Exception $e) {
            Db::rollback();
        }
    }
}
