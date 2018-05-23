<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/16
 * Time: 11:02
 */

/**
 * 腾讯地图根据经纬度获取地址或者根据地址获取经纬度
 */
class TxMap
{
    /**
     * @param $address
     * @return mixed
     * 根据地址获取经纬度
     */
    public static function getLngLat($address){
        $data = [
            'address'=>$address,
            'key'=>config('tx.key')
        ];
        $url = config('tx.tx_url').'?'.http_build_query($data);
        $result = doCurl($url);
        return json_decode($result,true);
    }
    /**
     * @param $lng
     * @param $lat
     * @return mixed
     * 根据经纬度获取地址
     */
    public static function getAddress($lng,$lat){
        $data = [
            'location'=>$lat.','.$lng,
            'key'=>config('tx.key'),
            'get_poi'=>0
        ];
        $url = config('tx.tx_url').'?'.http_build_query($data);
        $result = doCurl($url);
        return json_decode($result,true);
    }
}