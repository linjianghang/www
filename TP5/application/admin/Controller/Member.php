<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:26
 */
namespace app\admin\controller;

use app\admin\model\User;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;

class Member extends Power
{
    public function index(){
        $data = Request::instance()->param();
        $user = User::get(Cookie::get('user_id'));
        if(!$user){
            $this->redirect('login/index');
        }
        $sex = '--';
        $status = '--';
        $m = new User();
        $query = $m->where('type',0);
        if($user->type >= 2){
            $query->where('p_id','>',0);
        }else{
            $query->where('p_id',$user->id);
        }
        if(!empty($data['username'])){
            $this->assign('username', $data['username']);
            $query->where('username','like',$data['username']);
        }
        if(isset($data['sex']) && is_numeric($data['sex'])){
            $sex = $data['sex'];
            $query->where('sex',$data['sex']);
        }
        if(isset($data['status']) && is_numeric($data['status'])){
            $status = $data['status'];
            $query->where('status',$data['status']);
        }
        $list = $query->order('id desc')->paginate(10);
        $page = $list->render();
        $this->assign('sex', $sex);
        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->assign('page', $page);
        return view();
    }
    public function disabled(){
        $data = Request::instance()->param();
        if(!$data['id']){
            echo "<script>alert('请选择成员');window.location.href = document.referrer; </script>";
        }
        $user = User::get($data['id']);
        if($user){
            if($user->status == 0){
                $user->status = 1;
                $msg = '禁用成功';
            }else{
                $user->status = 0;
                $msg = '启用成功';
            }
            if($user->save()){
                echo "<script>alert('".$msg."');window.location.href = document.referrer; </script>";
            }else{
                echo "<script>alert('操作失败');window.location.href = document.referrer; </script>";
            }
        }else{
            echo "<script>alert('成员不存在了');window.location.href = document.referrer; </script>";
        }
    }
    public function edit_view(){
        $data = Request::instance()->param();
        if(!$data['id']){
            echo "<script>alert('请选择成员');window.location.href = document.referrer; </script>";
        }
        $data = \app\admin\model\User::where(['id'=>$data['id']])->find()->toArray();
        if($data){
            $this->assign('user',$data);
        }
        return view('edit');
    }
    public function edit(){
        $data = Request::instance()->param();
        if(!$data['id']){
            echo "<script>alert('请选择成员');window.location.href = document.referrer; </script>";
        }
        if(!empty($_FILES[key($_FILES)]['name'])){
            $data['head'] = Upload::UploadsOne(key($_FILES));
        }
        $m = \app\admin\model\User::get($data['id']);
        if($m->save($data) !== false){
            echo "<script>alert('保存成功');window.location.href = document.referrer; </script>";
        }else{
            echo "<script>alert('保存失败');window.history.back(); </script>";
        }
    }
    public function add_view(){
        return view('add');
    }
    public function add(){
        $data = Request::instance()->param();
        $m = new User();
        if(!empty($_FILES[key($_FILES)]['name'])){
            $data['head'] = Upload::UploadsOne(key($_FILES));
        }
        $data['password'] = md5(123456);
        $data['ctime'] = time();
        $data['type'] = 0;
        $data['p_id'] = Cookie::get('user_id');
        if($m->save($data) !== false){
            echo "<script>alert('添加成功');window.location.href = document.referrer; </script>";
        }else{
            echo "<script>alert('添加失败');window.history.back(); </script>";
        }
    }
}