<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/1
 * Time: 20:00
 */

namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\model\Role as RoleModel;
use app\admin\controller\Base;
use think\Loader;
class Admin extends Base
{
    //列表
    public function lst()
    {
        $admin = new AdminModel();
        $adminres = $admin
                    ->alias('a')->join('cs_role b','a.roleid=b.id')
                    ->field('a.*,b.rolename')
                    ->order('id','asc')
                    ->select();
        $this->assign('adminres',$adminres);
        return $this->fetch('lst');
    }

    //添加
    public function add()
    {
        if (request()->isPost()){
            //验证
            $data = input('post.');
            $validate = Loader::validate('Admin');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $admin = new AdminModel();
            $res = $admin->addadmin($data);
            if ($res){
                $this->success('添加成功！','lst');
            }else{
                $this->error('添加失败！');
            }
            return;
        }
        $role = new RoleModel();
        $roles = $role->select();
        $this->assign('roles',$roles);
        return $this->fetch('add');
    }

    //编辑
    public function edit($id)
    {
        $admin = db('admin')->find($id);
        if (request()->isPost()){
            //验证
            $data = input('post.');
            $validate = Loader::validate('Admin');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $update = new AdminModel();
            $savenum = $update->saveadmin($data,$admin);
            if ($savenum == '2'){
                $this->error('管理员名称不能为空！');
            }
            if ($savenum !== false){
                $this->success('修改成功！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;
        }
        $role = new RoleModel();
        $roles = $role->select();
        $this->assign('roles',$roles);
        $this->assign('admin',$admin);
        return $this->fetch('edit');
    }

    //单个删除
    public function del($id)
    {
        $admin = new AdminModel();
        if ($id==1){
            $this->error('admin不能删除！');
        }
        $delnum = $admin->deladmin($id);
        if ($delnum == '1'){
            $this->success('删除成功！','lst');
        }else{
            $this->error('删除失败！');
        }
    }

    //批量删除
    public function bdel()
    {
        $ids = input('ids/a');
        if ($ids){
            $id = implode(',',$ids);
            $del = db('admin')->delete($id);
            if ($del){
                $this->success('批量删除成功！','lst');
            }else{
                $this->error('批量删除失败！');
            }
        }else{
            $this->error('未选中内容！');
        }
    }

    //退出登录
    public function logout()
    {
        session(null);
        $this->success('退出成功','login/index');
    }
}