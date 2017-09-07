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