<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/6
 * Time: 19:48
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;
class Base extends Controller
{
    public function _initialize()
    {
        if (!session('id') || !session('username')){
            $this->error('您尚未登录系统','login/index');
        }
        $request = Request::instance();
        $mod = $request->module(); //获取模块名称
        $con = $request->controller(); //获取控制器名称
        $action = $request->action(); //获取方法名称
        $name = $mod . '/' . $con . '/' . $action;
        $url = strtolower($name);
        if ($mod=='admin' && $con=='Index'){
            return true;
        }
        if ($mod=='admin' && $con=='Admin' && $action=='logout'){
            return true;
        }
        if (session('id')!=1){
            if (!in_array($url,session('privilege'))){
                $this->error('没有访问权限！');
            }
        }
    }
}