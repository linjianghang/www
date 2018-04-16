<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:26
 */
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Img extends Power
{
    public function index(){
        return view();
    }
    public function upload(){
        if(!empty($_FILES[key($_FILES)]['name'])){
            $url = Upload::UploadsOne(key($_FILES));
            return json(['url'=>$url]);
        }else{
            return false;
        }
    }
}