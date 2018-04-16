<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28
 * Time: 10:55
 */

namespace app\index\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Debug;
use think\Env;
use think\Request;
use think\Route;

class Demo extends Controller
{
    //控制器初始方法
    public function _initialize(){

    }
    //前置方法
    protected $beforeActionList = [
//        'index',
//        'demo' =>  ['except'=>'demo'],
//        'demo2'  =>  ['only'=>'demo,index'],
    ];
    //空操作
    public function _empty()
    {
        echo "空操作";
    }

    public function index(){
        echo "Demo-Index";
    }
    public function demo(){
        //加载页面
//        $view = new \think\View();
//        return $view->fetch('index');

//        return view('index');

//        return $this->fetch('index');

//        //支持跨模块调用
//        $event = controller('index/User', 'event');
//        //支持跨控制器调用
//        $event = action('User/index',['id'=>1],'event');

        //获取URL信息
//        $request = request()->ext();

        //是否设置参数
//        var_dump(input('?get.id'));exit;

        // 获取当前请求的name变量
        var_dump(Request::instance()->param('name'));exit;
        // 获取当前请求的所有变量（经过过滤）
        Request::instance()->param();
        // 获取当前请求的所有变量（原始数据）
        Request::instance()->param(false);
        // 获取当前请求的所有变量（包含上传文件）
        Request::instance()->param(true);

        input('param.name');
        input('param.');
        //或者
        input('name');
        input('');

        Request::instance()->get('id'); // 获取某个get变量
        Request::instance()->get('name'); // 获取get变量
        Request::instance()->get(); // 获取所有的get变量（经过过滤的数组）
        Request::instance()->get(false); // 获取所有的get变量（原始数组）

        input('get.id');
        input('get.name');
        input('get.');

        input('session.user_id');
        input('session.');

        input('cookie.user_id');
        input('cookie.');

        // 更改GET变量
        Request::instance()->get(['id'=>10]);
        // 更改POST变量
        Request::instance()->post(['name'=>'thinkphp']);
        // 更改请求变量
        Request::instance()->param(['id'=>10]);

        $request = \think\Request::instance();
        echo "当前模块名称是" . $request->module()."<br/>";
        echo "当前控制器名称是" . $request->controller()."<br/>";
        echo "当前操作名称是" . $request->action()."<br/>";

        echo  '<br/>';
        $request = \think\Request::instance();
        echo '请求方法：' . $request->method() . '<br/>';
        echo '资源类型：' . $request->type() . '<br/>';
        echo '访问ip地址：' . $request->ip() . '<br/>';
        echo '是否AJax请求：' . var_export($request->isAjax(), true) . '<br/>';
        echo '请求参数：';
        var_dump($request->param());
        echo '请求参数：仅包含name';
        var_dump($request->only(['name']));
        echo '请求参数：排除name';
        var_dump($request->except(['name']));

        //获取某个请求头信息
        $agent = Request::instance()->header('user-agent');

    }
    public function demo2(){
        echo "测试2";
    }
    public function miss(){
        echo "<h1>页面错误</h1>";
    }
    //跳转 重定向
    public function Jump(){
//        $this->success('跳转成功', 'Demo/JumpIndex');
//        $this->error('失败');
        $this->redirect('demo/demo', ['id' => 2]);
    }
    public function JumpIndex(){
        echo "跳转页面";
    }
    public function db(){
        //查询
        $data = Db::query('select * from demo_user');
        //  查询一条
        $data = Db::table('demo_user')->where('id',15)->find();
        //  查询多条
        $data = Db::table('demo_user')->where('id > 10')->select();
        //设置了表前缀
//        Db::name('user')->where('id',1)->find();
        // 返回某个字段的值
        $data = Db::table('demo_user')->where('id',1)->value('username');
        // 返回数组
        $data = Db::table('demo_user')->where('id > 10')->column('username');
        //查询方法
        //  and
        $data = Db::table('demo_user')
            ->where('username','like','%data%')
            ->where('status',0)
            ->select();
        $data = Db::table('demo_user')
            ->where('username&password','like','%1%')
            ->select();
        //or
        $data = Db::table('demo_user')
            ->where('username','like','%1%')
            ->whereOr('password','like','%1%')
            ->select();
        $data = Db::table('demo_user')
            ->where('username|password','like','%1%')
            ->select();

        //混合查询
        $data = Db::table('demo_user')->where(function ($query) {
            $query->where('id', 1)->whereor('id', 2);
        })->whereOr(function ($query) {
            $query->where('username', 'like', '%1%')->whereOr('username', 'like', '%d%');
        })->select();
        /**
            // 获取`think_user`表所有信息
            Db::getTableInfo('think_user');
            // 获取`think_user`表所有字段
            Db::getTableInfo('think_user', 'fields');
            // 获取`think_user`表所有字段的类型
            Db::getTableInfo('think_user', 'type');
            // 获取`think_user`表的主键
            Db::getTableInfo('think_user', 'pk');
         */

        $data = Db::table('demo_user')->where('time','<>',1)->select();
        $data = Db::table('demo_user')
            ->where('status',0)
            ->order('time desc')
            ->limit(10)
            ->select();
        //查询指定字段
        $data = Db::table('demo_user')->field('username,age')->select();

        $map['username'] = 'data';
        $map['status'] = 0;
        // 把查询条件传入查询方法
        $data = Db::table('demo_user')->where($map)->select();

        $map['id']  = ['>',1];
        $map['username']  = ['like','%d%'];
        $data = Db::table('demo_user')->where($map)->select();

        //order
        $data = Db::table('demo_user')->order('status desc')->order('age desc')->select();
        $data = Db::table('demo_user')->order('status desc,age desc')->select();
        //limit
        $data = Db::table('demo_user')->limit('0,3')->select();
        //page
        $data = Db::table('demo_user')->page('1,3')->select();
        $data = Db::table('demo_user')->page(1,3)->select();
        $data = Db::table('demo_user')->limit(3)->page(3)->select();
        //group
        $data = Db::table('demo_user')->field('*')->group('id')->select();
        //having
        $data = Db::table('demo_user')->field('*')->group('id')->having('status>=1')->select();
        //join
        //union
        $data = Db::table('demo_user')->field('username')
            ->union('select username from demo_user')
            ->union('select username from demo_user')
            ->select();
        //distinct  方法用于返回唯一不同的值
        $data = Db::table('demo_user')->distinct(true)->field('username')->select();
        //cache
        $data = Db::table('demo_user')->cache('*')->select(1);
        $data = Db::table('demo_user')->cache(false)->select();
        //返回sql
        $data = Db::table('demo_user')->fetchSql(true)->find(2);
        //count sum min max avg
        $data = Db::table('demo_user')->count();

        //高级查询
        $data = Db::table('demo_user')
            ->where('id',['>',0],['<>',10],'or')
            ->select();
        $data = Db::table('demo_user')
            ->where([
                'password'  =>  ['like','%1%'],
                'id'    =>  ['>',0]
            ])
            ->select();
        $m = new \app\index\model\Demo();
        $datas = $m->find();
        $datas = $datas->toJson();
        var_dump($datas);exit;

        //  添加
//        $res = Db::execute("insert into demo_user values (16,'名称',123,1,0,'2018-01-04 17:44:00',0)");
//        $res = Db::table('demo_user')->insert(['username'=>'添加的名称','password'=>123]);
        //获取添加id
//        $userId = Db::table('demo_user')->getLastInsID();
        // 添加单条数据
//        $res = db('demo_user')->insert(['username'=>'添加的名称','password'=>123]);
        // 添加多条数据
//        $res = db('demo_user')->insertAll([['username'=>'添加的名称','password'=>123],['username'=>'添加的名称2','password'=>123]]);
        // 快捷添加
//        $res = Db::table('demo_user')->data(['username'=>'tp','password'=>1000])->insert();



        //  更新
//        $res = Db::execute("update demo_user set username='修改名称' where id=16");
//        $res = Db::table('demo_user')->where('id',15)->update(['username'=>'修改的','password'=>233]);
        //  如果数据中包含主键，可以直接使用：
//        $res = Db::table('demo_user')->update(['username' => 'thinkphp','id'=>15]);
        //  使用函数
//        $res = Db::table('demo_user')->where('id', 15)
//            ->update([
//                'time'  => ['exp','now()'],
//            ]);
        //更新某个字段的值：
//        $res = Db::table('demo_user')->where('id',15)->setField('username', 'username');
        // age 字段加 1
//        $res = Db::table('demo_user')->where('id', 1)->setInc('age');
        // age 字段加 5
//        $res = Db::table('demo_user')->where('id', 1)->setInc('age', 5);
        // age 字段减 1
//        $res = Db::table('demo_user')->where('id', 1)->setDec('age');
        // age 字段减 5
//        $res = Db::table('demo_user')->where('id', 1)->setDec('age', 5);
        //  延时10秒，给age字段增加1
//        $res = Db::table('demo_user')->where('id', 1)->setInc('age', 1, 10);
        /**
            // 更新数据表中的数据
            db('user')->where('id',1)->update(['name' => 'thinkphp']);
            // 更新某个字段的值
            db('user')->where('id',1)->setField('name','thinkphp');
            // 自增 score 字段Users.php
            db('user')->where('id', 1)->setInc('score');
            // 自减 score 字段
            db('user')->where('id', 1)->setDec('score');
         */


        //  删除
//        $res = Db::execute("delete from demo_user where id=16");
        // 根据主键删除
//        Db::table('think_user')->delete(1);
//        Db::table('think_user')->delete([1,2,3]);
        // 条件删除
//        Db::table('think_user')->where('id',1)->delete();
//        Db::table('think_user')->where('id','<',10)->delete();
    }
    public function model(){
        $m = new \app\index\model\Demo();
//        $m->username = '模板新增';
//        $m->password = 123;
//        $m->save();
//        var_dump($m->id);

//        $list = [
//            ['username'=>'thinkphp','password'=>123],
//            ['username'=>'onethink','password'=>456]
//        ];
//        $m->saveAll($list);
//        var_dump($m);

//        $data = $m->get(1);
//        $data->username = '修改';
//        var_dump($data->save());

//        $m->save([
//            'username'  => '修改的内容',
//            'password' => '123'
//        ],['id' => 1]);

        //批量更新
//        $list = [
//            ['id'=>1, 'username'=>'thinkphp', 'password'=>123],
//            ['id'=>2, 'username'=>'onethink', 'password'=>123456]
//        ];
//        $m->saveAll($list);

//        $res = \app\index\model\Demo::where('id', 1)->update(['username' => '修改的']);
//        $res = \app\index\model\Demo::update(['id' => 1, 'username' => '修改的2']);
//        var_dump($res);

        //删除
//        $m = $m->get(30);
//        $res = $m->delete();
//        $res = \app\index\model\Demo::destroy('28,29');
//        $res = \app\index\model\Demo::destroy(function($query){
//            $query->where('id','>',14);
//        });

//        $data['username'] = 'THINKPHP';
//        $data['password'] = 23333;
//        $m->data($data, true);
//        $res = $m->save();
//        var_dump($res);
        $data = $m->find(1)->toArray();
        var_dump($data);exit;
    }
    public function view(){
        // 渲染模板输出
//        return $this->fetch('index',['name'=>'thinkphp']);
//        return view('index',['name'=>'thinkphp']);
        // 模板变量赋值
//        $this->assign('name','ThinkPHP');
//        $this->assign('email','thinkphp@qq.com');
//        // 或者批量赋值
//        $this->assign([
//            'name1'  => 'ThinkPHP',
//            'email2' => 'thinkphp@qq.com'
//        ]);
        // 模板输出
//        return $this->fetch('index');
        //表示调用当前控制器下面的edit模板
//        return $this->fetch('member/read');
        //跨模块渲染模板
//        return $this->fetch('admin@member/edit');
        Debug::remark('begin');
// ...其他代码段
        Debug::remark('end');
// ...也许这里还有其他代码
// 进行统计区间
        echo Debug::getRangeTime('begin','end').'s';
        return view('index',['name'=>'look me','status'=>1,'list'=>array(['name'=>'第一','phone'=>'123456'],['name'=>'第二','phone'=>'654321'])]);
    }
    public function page(){
//        // 查询状态为1的用户数据 并且每页显示10条数据
//        $list = \app\index\model\Demo::where('status',0)->paginate(10);
//// 把分页数据赋值给模板变量list
//        $this->assign('list', $list);
//// 渲染模板输出
//        return $this->fetch('demo');
        // 查询状态为1的用户数据 并且每页显示10条数据

        //paginate 第二个参数true 隐藏数字导航
        $list = \app\index\model\Demo::where('status',0)->paginate(4);
        // 获取分页显示
        $page = $list->render();
        // 模板变量赋值
        $this->assign('list', $list);
        $this->assign('page', $page);
        // 渲染模板输出
//        var_dump($list->total());exit;//总数
        return $this->fetch('demo');
    }
    public function upload_html(){
        return view('upload');
    }
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        $dir = ROOT_PATH . 'public' . DS . 'uploads';
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move($dir);
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
//                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
//                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
    }
    public function img(){
        $dir = 'C:\wamp64\www\TP5\public\uploads\20180115\0.jpg';
        $image = \think\Image::open($dir);
//        // 返回图片的宽度
//        $width = $image->width();
//// 返回图片的高度
//        $height = $image->height();
//// 返回图片的类型
//        $type = $image->type();
//// 返回图片的mime类型
//        $mime = $image->mime();
//// 返回图片的尺寸数组 0 图片宽度 1 图片高度
//        $size = $image->size();
//        //将图片裁剪为300x300并保存为crop.png
//        $image->crop(300, 300)->save($dir);
        //对图像进行以x轴进行翻转操作
//        $image->flip()->save($dir);
        // 对图像进行以y轴进行翻转操作
//        $image->flip(\think\image::FLIP_Y)->save($dir);
        // 对图像使用默认的顺时针旋转90度操作
        $image->rotate()->save($dir);
        return view('img',['im
        g'=>$dir]);
    }
    public function event(){
        $m = new \app\index\model\Demo();
        /**
            before_insert	新增前
            after_insert	新增后
            before_update	更新前
            after_update	更新后
            before_write	写入前
            after_write	    写入后
            before_delete	删除前
            after_delete	删除后
         */
        \app\index\model\Demo::event('before_insert', function ($user) {
            if ($user->status != 1) {
                return false;
            }
        });
        $m->username='233';
        $m->status = 0;
        var_dump($m->save());
    }
}