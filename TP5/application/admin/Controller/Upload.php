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

class Upload extends Controller
{
    static function UploadsOne($name,$reu = 0){
        $file = request()->file($name);
        $filemd = md5_file($file->getpathName());//加密
//        $file = substr($filemd , 0 , 8).'/'.$filemd. '.' . $file->getExtension();
        $newString = strstr($file->getInfo()['name'], '.');
        $length = strlen('.');
        $extension = substr($newString, $length);
        $AllFile = substr($filemd , 0 , 8).'/'.$filemd. '.' . $extension;
        $dir = ROOT_PATH . 'public' . DS . 'uploads/';
        if($file){
            //开始检验是否有此图
            if(!file_exists($dir.$AllFile)) {
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move($dir,$AllFile);
                if($info){
                    if($reu == 1){
                        $attr = array(
                            "state" => 'SUCCESS',//上传状态信息,  SUCCESS
                            "url" => $dir.$AllFile,//完整文件名,即从当前配置目录开始的URL
                            "title" => $filemd. '.' . $extension,//新文件名
                            "original" => $filemd. '.' . $extension,//完整文件名,即从当前配置目录开始的URL
                            "type" => $_FILES[$name]['type'],//文件类型
                            "size" => round($info->getSize() / 1024, 2)//文件大小
                        );
                        return $attr;
                    }else{
                        // 成功上传后 获取上传信息 getExtension返回扩展名 getSaveName返回路径 getFilename返回文件名
                        return str_replace("\\",'/',$info->getSaveName());
                    }
                }else{
                    // 上传失败获取错误信息
                    return $file->getError();
                }
            }else{
                return $AllFile;
            }
        }
    }
    //富文本上传
    public function upload_img(){
        if(!empty($_FILES[key($_FILES)]['name'])){
            return $this->UploadsOne(key($_FILES),1);
        }else{
            return false;
        }
    }
}