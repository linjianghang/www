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
Route::controller('user','index/User');
//Route::get('/',function(){
//    return '默认访问';
//});
//默认进入的方法
//Route::get('/','home/index/index');
//Route::get('/','admin/index/index');


//定义路由
/**
    method              请求类型检测，支持多个请求类型
    ext	                URL后缀检测，支持匹配多个后缀
    deny_ext	        URL禁止后缀检测，支持匹配多个后缀
    https	            检测是否https请求
    domain	            域名检测
    before_behavior	    前置行为（检测）
    after_behavior	    后置行为（执行）
    callback	        自定义检测方法
    merge_extra_vars	合并额外参数
    bind_model	        绑定模型（V5.0.1+）
    cache	            请求缓存（V5.0.1+）
    param_depr	        路由参数分隔符（V5.0.2+）
    ajax	            Ajax检测（V5.0.2+）
    pjax	            Pjax检测（V5.0.2+）
 */
Route::get('new/:id','index/demo/index',['domain'=>'localhost']);

//别名
Route::alias('demos','index/demo');

//Miss
//Route::miss('public/index/demo/miss');

// 绑定当前的URL到 index模块的demo控制器的demo操作
//Route::bind('index/demo/demo');

//域名绑定
//Route::domain('admin.thinkphp.cn','index');
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];

