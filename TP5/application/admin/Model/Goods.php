<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/17
 * Time: 16:20
 */
namespace app\admin\model;
use think\Model;

class Goods extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'pr_goods';
    // 设置当前模型的数据库连接
//    protected $connection = [
//        // 数据库类型
//        'type'        => 'mysql',
//        // 服务器地址
//        'hostname'    => '127.0.0.1',
//        // 数据库名
//        'database'    => 'demo',
//        // 数据库用户名
//        'username'    => 'root',
//        // 数据库密码
//        'password'    => '',
//        // 数据库编码默认采用utf8
//        'charset'     => 'utf8',
//        // 数据库表前缀
//        'prefix'      => 'demo_',
//        // 数据库调试模式
//        'debug'       => false,
//    ];
    //支持多条数据 toArray toJson
    protected $resultSetType = 'collection';
}