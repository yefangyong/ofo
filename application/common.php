<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------



/**
 * @param $url
 * @param $type 1|post方式 0|get方式
 * @param array $data
 */
function doCurl($url,$type = 0,$data=[]) {
    $cu = curl_init(); //初始化
    //设置选项
    curl_setopt($cu,CURLOPT_URL,$url); //设置url
    curl_setopt($cu,CURLOPT_RETURNTRANSFER,1); //信息以文件流的方式保存，而不是直接输出
    curl_setopt($cu,CURLOPT_HEADER,0); //不包括header头部信息
    if($type == 1) {
        //post
        curl_setopt($cu,CURLOPT_POST,1);
        curl_setopt($cu,CURLOPT_POSTFIELDS,$data);
    }
    //执行并获取内容
    $output = curl_exec($cu);
    //释放curl句柄
    curl_close($cu);
    return $output;
}
// 应用公共文件
/**
 * @param $url
 * @param int $httpCode
 * @return mixed
 * 获取网咯资源
 */
function curl_get($url,&$httpCode = 0) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,10);
    $file_contents = curl_exec($curl);
    $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);
    return $file_contents;
}

/**
 * @param $length
 * @return string
 * 获取随机的字符串
 */
function getRandChars($length) {
    $str = '';
    $strPol = 'QWERTYUIOPASDFGHJKLXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm';
    $max =strlen($strPol)-1;
    for($i=0;$i<$length;$i++) {
        $str.=$strPol[rand(0,$max)];
    }
    return $str;
}

/**
 * @param $status
 * @param $message
 * @param array $data
 * 公用的展示方法
 */
function show($status,$message,$data =array()){
    $result = [
        'status'=>$status,
        'message'=>$message,
        'data'=>$data
    ];
    exit(json_encode($result));
}

/**
 * @param $code
 * @return string
 * 车辆的使用情况
 */
function userStatus($code) {
    if($code == 0) {
        return '未使用';
    }else {
        return "使用中";
    }
}

/**
 * @param $code
 * @return string
 * 车辆是否发生故障
 */
function troubleStatus($code) {
    if($code == 0) {
        return "正常";
    }else {
        return "故障";
    }
}

/**
 * @param $value
 * @return string
 * 单车的修理状态
 */
 function getStatusAttr($value) {
    if($value == 0) {
        return $value = '待修理';
    }elseif($value == 1) {
        return $value = '已修理';
    }
}

