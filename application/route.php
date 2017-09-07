<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//bike
Route::post('api/:version/bike/status','api/:version.bike/updateBikeStatus');
Route::get('api/:version/bike','api/:version.bike/getBicyclePosition');
Route::post('api/:version/bike','api/:version.bike/getBikeByID');


//token
Route::post('api/:version/token/user','api/:version.token/getToken');
Route::post('api/:version/token/verify','api/:version.token/verifyToken');

//user
Route::post('api/:version/user/wallet','api/:version.user/getUserInfo');
Route::post('api/:version/user/pay','api/:version.user/pay');
Route::post('api/:version/user/refund','api/:version.user/refund');
Route::post('api/:version/user/record','api/:version.user/record');