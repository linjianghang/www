<?php

/**
 * 权限模板
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/17
 * Time: 10:26
 */
namespace app\admin\controller;

use think\Controller;
use think\Cookie;
use think\Db;

class Power extends Controller
{
    protected $user_id;
    public function __construct()
    {
        $this->user_id = Cookie::get('user_id');
        parent::__construct();
        $request = \think\Request::instance();
        $url = strtolower($request->controller().'/'.$request->action());
        if($this->user_id){
            $UserInfo = \app\admin\model\User::where('id',$this->user_id)->find();
            if(!$UserInfo){
                $this->redirect('login/index');
            }
            $menu = Db::table('pr_menu')->where('status',0)->order('sort')->select();
            $MenuList = array();
            foreach($menu as $k=>$v){
                if($v['parent_id'] == 0){
                    $MenuList[$v['id']]['id'] = $v['id'];
                    $MenuList[$v['id']]['name'] = $v['name'];
                    $MenuList[$v['id']]['route'] = $v['route'];
                    $MenuList[$v['id']]['items'] = array();
                    $MenuList[$v['id']]['class'] = ($v['route'] == $url) ? 'active-menu' : '';
                    $MenuList[$v['id']]['in'] = '';
                }else{
                    $MenuList[$v['parent_id']]['items'][] = array(
                        'id'=>$v['id'],
                        'name'=>$v['name'],
                        'route'=>$v['route'],
                        'class'=>($v['route'] == $url) ? 'active-menu' : '',
                    );
                }
            }
            foreach($MenuList as $k=>$v){
                if(!empty($v['items'])){
                    foreach($v['items'] as $ks=>$vs){
                        if(!empty($vs['class'])){
                            $MenuList[$k]['class'] = 'active-menu-top';
                            $MenuList[$k]['in'] = 'in';
                        }
                    }
                }
            }
            $MenuList = array_merge($MenuList);
            $this->assign('url',$url);
            $this->assign('layout_user',$UserInfo);
            $this->assign('layout_menu',$MenuList);
        }else{
            $this->redirect('login/index');
        }
    }
}