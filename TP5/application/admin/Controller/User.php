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

class User extends Power
{
    public function index(){
        $data = \app\admin\model\User::where(['id'=>$this->user_id])->find()->toArray();
        $this->assign('user',$data);
        return view();
    }
    public function edit(){
        $data = Request::instance()->param();
        if(!empty($_FILES[key($_FILES)]['name'])){
            $data['head'] = Upload::UploadsOne(key($_FILES));
        }
        $m = \app\admin\model\User::get($this->user_id);
        if($m->save($data) !== false){
//            location.href="{:U('Vote/index')}";
            echo "<script>alert('保存成功');window.location.href = document.referrer; </script>";
//            $this->success('保存成功','user/index');
        }else{
            echo "<script>alert('保存失败');window.history.back(); </script>";
//            $this->error('保存失败','user/index');
        }
    }
}