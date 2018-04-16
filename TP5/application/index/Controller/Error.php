<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/12
 * Time: 16:57
 */

namespace app\index\controller;

use think\Request;
class Error
{
    public function index(Request $request){
        echo "没有这个控制器";
    }
}