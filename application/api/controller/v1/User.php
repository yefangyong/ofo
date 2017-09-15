<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/9/1
 * Time: 16:59
 */

namespace app\api\controller\v1;

use app\api\model\Charge;
use app\api\model\Record;
use app\api\service\Token;
use app\lib\exception\UserException;
use app\api\model\User as UserModel;
use think\Db;
use think\Exception;

class User extends Base
{
    /**
     * @return null|static
     * @throws UserException
     * 获取用户的信息
     */
    public function getUserInfo(){
        $uid = Token::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user) {
            throw new UserException();
        }
        return $user;
    }

    /**
     * @param $guarantee
     * 充值
     */
    public function pay($from,$price) {
        $type = 1;
        if($from == 'index') {
            $type = 0;
        }else if($from == 'wallet' || $from == 'pay') {
            $type = 1;
        }
        $uid = Token::getCurrentUid();
        Db::startTrans();
        try{
            if($type == 1) {
                $user = UserModel::get($uid);

                $price = $price + $user->balance;
                $result = new UserModel();
                $res = $result->save(['balance'=>$price],['id'=>$uid]);
            }else {
                $res = UserModel::update(['guarantee'=>$price],['id'=>$uid]);
            }
            $rel = Charge::create([
                'price'=>$price,
                'type'=>$type,
                'user_id'=>$uid
            ]);
            if($rel && $res) {
                Db::commit();
            }
        }catch (Exception $e) {
            Db::rollback();
            throw new UserException([
                'msg'=>'充值失败'
            ]);
        }
    }

    /**
     * @param $price
     * @return array
     * 押金退款
     */
    public function refund() {
        $uid = Token::getCurrentUid();
        $res = UserModel::update(['guarantee'=>0],['id'=>$uid]);
        $rel = Charge::create([
            'price'=>0,
            'type'=>0,
            'user_id'=>$uid
        ]);
        if($rel && $res) {
            return [
                'msg'=>'退款成功',
                'code'=>201
            ];
        }
    }


    /**
     * @param $start_time
     * @param $bikeID
     * @param $end_time
     * @param $start_long
     * @param $start_lati
     * @param $end_long
     * @param $end_lati
     * @param $price
     * 用户骑行后记录到数据库
     */
    public function record($start_time,$bikeID,$end_time,$start_long,$start_lati,$end_long,$end_lati,$price) {
        $uid = Token::getCurrentUid();
        $data = [
            'start_time'=>$start_time,
            'end_time'=>$end_time,
            'start_long'=>$start_long,
            'start_lati'=>$start_lati,
            'end_lati'=>$end_lati,
            'end_long'=>$end_long,
            'total_price'=>$price,
            'user_id'=>$uid,
            'bike_id'=>$bikeID
        ];
        Db::startTrans();
        try {
            //创建记录
            $res = Record::create($data);

            //修改用户的余额
            $user = new UserModel();
            $userInfo = $user->find($uid);
            $data = [
                'balance'=>$userInfo->balance-$price
            ];
            $rel = $user->save($data,['id'=>$uid]);


            //修改小黄车的状态和位置
            $bikeData = [
                'is_show'=>'0',
                'latitude'=>$end_lati,
                'longitude'=>$end_long
            ];
            $rs = \app\api\model\Bike::update($bikeData,['id'=>$bikeID]);



            if($res && $rel && $rs) {
               echo 'success';
                Db::commit();
            }
        }catch (Exception $e) {
            Db::rollback();
        }
    }
}