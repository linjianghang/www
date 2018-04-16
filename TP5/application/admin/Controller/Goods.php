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
use think\Request;
use app\admin\model\User;

class Goods extends Power
{
    //商品列表
    public function goods_list(){
        $data = Request::instance()->param();
        $user = User::get(Cookie::get('user_id'));
        if(!$user){
            $this->redirect('login/index');
        }

        $m = new \app\admin\model\Goods();
        $query = $m;
        if(!empty($data['name'])){
            $this->assign('name', $data['name']);
            $query->where('name','like','%'.$data['name'].'%');
        }
        $list = $query->order('id desc')->paginate(8);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return view();
    }
    public function goods_disabled(){
        $data = Request::instance()->param();
        if(!$data['id']){
            echo "<script>alert('请选择商品');window.location.href = document.referrer; </script>";
        }
        $goods = \app\admin\model\Goods::get($data['id']);
        if($goods){
            if($goods->status == 0){
                $goods->status = 1;
                $msg = '禁用成功';
            }else{
                $goods->status = 0;
                $msg = '启用成功';
            }
            if($goods->save()){
                echo "<script>alert('".$msg."');window.location.href = document.referrer; </script>";
            }else{
                echo "<script>alert('操作失败');window.location.href = document.referrer; </script>";
            }
        }else{
            echo "<script>alert('商品不存在了');window.location.href = document.referrer; </script>";
        }
    }
    //售出商品
    public function goods_add(){
        $data = Request::instance()->param();
        if(isset($data['id'])){
            $list = \app\admin\model\Goods::get($data['id']);
            $list['info_img'] = !empty($list['info_img']) ? $list['info_img'] : 'null';
            $this->assign('list',$list);
        }
        return view();
    }
    public function goods_add_save(){
        $data = Request::instance()->param();
        if(!empty($_FILES[key($_FILES)]['name'])){
            $data['img'] = Upload::UploadsOne(key($_FILES));
        }
        if(!empty($data['info_img'])){
            $data['info_img'] = json_encode($data['info_img']);
        }
        $m = new \app\admin\model\Goods();
        if(isset($data['id']) && !empty($data['id'])){
            $list = $m->get($data['id']);
            $res = $list->save($data);
            $msg = "修改成功";
        }else{
            $data['ctime'] = time();
            $m->data($data);
            $res = $m->save();
            $msg = "添加成功";
        }
        if($res){
            $this->success($msg,'goods/goods_list');
        }else{
            $this->error('操作失败','goods/goods_list');
        }

    }
}