<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/1
 * Time: 20:27
 */

namespace app\admin\model;

use think\Model;
use think\captcha\Captcha;
class Admin extends Model
{
    //添加
    public function addadmin($data)
    {
        if (empty($data) || !is_array($data)){
            return false;
        }
        if ($data['password']){
            $data['password'] = md5($data['password']);
        }
        $adminData = array();
        $adminData['username']=$data['username'];
        $adminData['password']=$data['password'];
        $adminData['roleid']=$data['roleid'];
        if ($this->save($adminData)){
            return true;
        }else{
            return false;
        }
    }

    //编辑
    public function saveadmin($data,$admin)
    {
        if (!$data['username']){
            return 2; //管理员名称为空
        }
        if (!$data['password']){
            $data['password'] = $admin['password'];
        }else{
            $data['password'] = md5($data['password']);
        }
        $res = $this::update([
            'username' => $data['username'],
            'password' => $data['password'],
            'roleid' => $data['roleid'],
        ],['id'=>$data['id']]);
        return $res;
    }

    //删除
    public function deladmin($id)
    {
        $res = $this::destroy($id);
        if ($res){
            return 1;
        }else{
            return 2;
        }
    }

    //登录
    public function login($data)
    {
        $captcha = new Captcha();
        if (!$captcha->check($data['code'])){
            return 4; //验证码错误
        }
        $admin = Admin::getByUsername($data['username']);
        if ($admin){
            if ($admin['password'] == md5($data['password'])){
                session('id', $admin['id']);
                session('username', $admin['username']);
                $this->getpri($admin['roleid']);
                return 2; //密码正确
            }else{
                return 3; //密码错误
            }
        }else{
            return 1; //用户不存在的情况
        }
    }

    //权限验证
    public function getpri($roleid)
    {
        $role = new Role();
        $info = $role->field('rolename,pri_id_list')->find($roleid);
        session('rolename', $info["rolename"]);
        $pri = new Privilege();
        $pris = $pri->field('CONCAT(mname,"/",cname,"/",aname) url')->where("id IN({$info['pri_id_list']})")->select();
        $_pris = array();
        foreach ($pris as $k=>$v){
            $_pris[]=$v['url'];
        }
        session('privilege', $_pris);
    }
}