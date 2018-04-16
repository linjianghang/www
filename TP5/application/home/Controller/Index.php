<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:26
 */
namespace app\home\controller;
use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller
{
    public function index(){
        $m = new \app\admin\model\Goods();
        $query = $m->where('status',0);
        $list = $query->order('id desc')->paginate(8);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return view();
    }
    public function info(){
        $data = Request::instance()->param();
        $id = isset($data['id']) ? $data['id'] : 0;
        if(!$id){
            $this->redirect('index/index');
        }
        $m = new \app\admin\model\Goods();
        $recommend = $m->where('status',0)->order('rand()')->limit(6)->select()->toArray();
        $data = $m->where('id',$id)->find()->toArray();
        $data['info_img'] = json_decode($data['info_img'],true);
        if($data['info_img']){
            $data['introduce'] = array_slice($data['info_img'],5);
        }else{
            $data['info_img'] = array();
            $data['introduce'] = array();
        }
        $this->assign('recommend', $recommend);
        $this->assign('data', $data);
        return view();
    }
}