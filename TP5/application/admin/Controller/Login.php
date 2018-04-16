<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:26
 */
namespace app\admin\controller;

use app\admin\model\User;
use think\captcha\Captcha;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;

class Login extends Controller
{
    public function index(){
        $captcha = new Captcha();
        $this->assign('code',$captcha->entry());
        return view('index');
    }
    public function login(){
        $data = Request::instance()->param();
        if(!captcha_check($data['code'])){
            return "<script>alert('验证码输入错误');window.history.back(); </script>";
        };
        $user = User::where('username',$data['username'])->find();
        if($user){
            if(md5($data['password']) == $user['password']){
                Cookie::set('user_id',$user['id'],3600);
                $user->ltime = time();
                $user->save();
                $this->redirect('index/index');
            }else{
                return "<script>alert('密码错误');window.history.back(); </script>";
            }
        }else{
            return "<script>alert('用户名不存在');window.history.back(); </script>";
        }
    }
    public function out(){
        Cookie::delete('user_id');
        $this->redirect('login/index');
    }
    public function register_view(){
        return view('register');
    }
    public function register(){
        $data = Request::instance()->param();
        $m = new User();
        $select = $m->where('username',$data['username'])->where('status',0)->find();
        if($select){
            return "<script>alert('用户名已存在');window.history.back(); </script>";
        }
        if($data['type'] == 2){
            $select = $m->where('type',2)->where('status',0)->find();
            if($select){
                return "<script>alert('该权限只能有一个');window.history.back(); </script>";
            }
        }
        try{
            $data['password'] = md5($data['password']);
            $data['ctime'] = time();
            $m->data($data);
            $result = $m->save();
        }catch(\Exception $e){
            $result = false;
        }
        if ($result == true) {
            return "<script>alert('注册成功');window.location.href = document.referrer;</script>";
        } else {
            return "<script>alert('注册失败');window.history.back(); </script>";
        }
    }
}