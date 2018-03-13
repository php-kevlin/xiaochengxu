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
/*
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
*/

use think\Route;
Route::rule('路由表达式','路由地址','请求类型','路由参数（数组）','变量规则（数组）');
//Route::rule('hello','sample/Test/hello','GET',['https'=>true]);
//Route::rule('hello','sample/Test/hello','GET|POST',['https'=>false]);
//Route::get('hello/:id','sample/Test/hello');
//Route::post('hello/:id','sample/Test/hello');
Route::get('api/v1/banner/:id','api/v1.Banner/getBanner');
