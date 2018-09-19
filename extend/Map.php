<?php
/**
 * Created by PhpStorm.
 * User: yefy
 * Date: 2017/10/12
 * Time: 17:59
 */

/*百度地图获取地址封装*/

class Map
{
    /**
     * @param $address
     * @return mixed
     * 根据地址获取经纬度
     */
    public static function getLngLat($address)
    {
        $data = [
            'address' => $address,
            'ak' => config('map.ak'),
            'output' => 'json'
        ];
        $url = config('map.baidu_map_url') . config('map.geocorder') . '?' . http_build_query($data);
        $result = doCurl($url);
        $result = json_decode($result, true);
        return $result;
    }

    /**
     * @param $lng
     * @param $lat
     * @return mixed
     * 根据经纬度获取单车的地址
     */
    public static function getAddress($lng, $lat)
    {
        $data = [
            'location' => $lng . ',' . $lat,
            'ak' => config('map.ak'),
            'output' => 'json'
        ];
        $url = config('map.baidu_map_url') . config('map.geocorder') . '?' . http_build_query($data);
        $result = curl_get($url);
        $result = json_decode($result, true);
        return $result;
    }
}