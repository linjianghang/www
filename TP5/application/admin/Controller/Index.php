<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:26
 */
namespace app\admin\controller;

use think\Controller;
use think\Cookie;
use think\Db;

class Index extends Power
{
    public function index(){
        return view();
    }
}