<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/6
 * Time: 12:00
 */

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Admin;
class Login extends Controller
{
    public function index()
    {
        if (request()->isPost()){
            $admin = new Admin();
            $data = input('post.');
            $num = $admin->login($data);
            if ($num==2){
                $this->success('信息正确,正在跳转...','index/index');
            }elseif ($num==4){
                $this->error('验证码错误');
            }else{
                $this->error('用户名或密码错误');
            }
        }
        return view();
    }
}