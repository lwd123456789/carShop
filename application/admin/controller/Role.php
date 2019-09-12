<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/5
 * Time: 19:08
 */

namespace app\admin\controller;

use app\admin\model\Privilege as PrivilegeModel;
use app\admin\model\Role as RoleModel;
use app\admin\controller\Base;
use think\Loader;
class Role extends Base
{
    //列表
    public function lst()
    {
        $role = new RoleModel();
        $roles = $role->alias('a')
                ->join('cs_privilege b','FIND_IN_SET(b.id,a.pri_id_list)')
                ->group('a.id')->field('a.*,GROUP_CONCAT(b.pri_name) pri_name')
                ->select();
        $this->assign('roles',$roles);
        return $this->fetch('lst'); 
    }

    //添加
    public function add()
    {
        $role = new RoleModel();
        if (request()->isPost()){
            $data = input('post.');
            //验证
            $validate = Loader::validate('Role');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            if (!empty($data["pri_id_list"])){
                $data["pri_id_list"] = implode(',',$data["pri_id_list"]);
            }else{
                $this->error('请选择角色权限！');
            }
            if ($role->save($data)){
                $this->success('添加成功！','lst');
            }else{
                $this->error('添加失败！');
            }
            return;
        }
        $pri = new PrivilegeModel();
        $pris = $pri->pritree();
        $this->assign('pris',$pris);
        return $this->fetch('add');
    }

    //编辑
    public function edit()
    {
        $role = new RoleModel();
        if (request()->isPost()){
            $data = input('post.');
            //验证
            $validate = Loader::validate('Role');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            if (!empty($data["pri_id_list"])){
                $data["pri_id_list"] = implode(',',$data["pri_id_list"]);
            }else{
                $this->error('请选择角色权限！');
            }
            $save = $role->save($data,['id'=>$data['id']]);
            if ($save !== false){
                $this->success('修改成功！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;
        }
        $roleres = $role->find(input('id'));
        $pri = new PrivilegeModel();
        $pris = $pri->pritree();
        $this->assign(array(
            'pris'=>$pris,
            'roleres'=>$roleres,
        ));
        return $this->fetch('edit');
    }

    //单个删除
    public function del($id)
    {
        $role = new RoleModel();
        if ($id==1){
            $this->error('超级管理员角色不能删除！');
        }
        $delnum = $role->delrole($id);
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
            $key = array_search('1',$ids);
            if ($key!==false){
                unset($ids[$key]);
            }
            $id = implode(',',$ids);
            $del = db('role')->delete($id);
            if ($del){
                $this->success('批量删除成功！','lst');
            }else{
                $this->error('批量删除失败！');
            }
        }else{
            $this->error('未选中内容！');
        }
    }
}