<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/2
 * Time: 16:23
 */

namespace app\admin\controller;

use app\admin\model\Privilege as PrivilegeModel;
use app\admin\controller\Base;
use think\Loader;
class Privilege extends Base
{
    //删除的前置操作
    protected $beforeActionList = [
        'delsonpri' => ['only'=>'del'],
        'bdelsonpri' => ['only'=>'bdel'],
    ];

    //列表
    public function lst()
    {
        $pri = new PrivilegeModel();
        $pris = $pri->pritree();
        $this->assign('pris',$pris);
        return $this->fetch('lst');
    }

    //添加
    public function add()
    {
        $pri = new PrivilegeModel();
        if (request()->isPost()){
            $data = input('post.');
            $data['mname'] = strtolower($data['mname']);
            $data['cname'] = strtolower($data['cname']);
            $data['aname'] = strtolower($data['aname']);
            //验证
            $validate = Loader::validate('Privilege');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            if ($pri->save($data)){
                $this->success('添加成功！','lst');
            }else{
                $this->error('添加失败！');
            }
            return;
        }
        $pris = $pri->pritree();
        $this->assign('pris',$pris);
        return $this->fetch('add');
    }

    //编辑
    public function edit()
    {
        $pri = new PrivilegeModel();
        if (request()->isPost()){
            $data = input('post.');
            //验证
            $validate = Loader::validate('Privilege');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $save = $pri->save($data,['id'=>$data['id']]);
            if ($save !== false){
                $this->success('修改成功！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;
        }
        $prires = $pri->find(input('id'));
        $pris = $pri->pritree();
        $this->assign(array(
            'prires' => $prires,
            'pris' => $pris,
        ));
        return $this->fetch('edit');
    }

    //删除
    public function del()
    {
        $del = db('privilege')->delete(input('id'));
        if ($del){
            $this->success('删除成功！','lst');
        }else{
            $this->error('删除失败！');
        }
    }

    //删除父权限之前先删除子权限
    public function delsonpri()
    {
        $priid = input('id');
        $pri = new PrivilegeModel();
        $sonids = $pri->getchilrenid($priid);
        if ($sonids){
            db('privilege')->delete($sonids);
        }
    }

    //批量删除
    public function bdel()
    {
        $ids = input('ids/a');
        $id = implode(',',$ids);
        if ($ids){
            $del = db('privilege')->delete($id);
            if ($del){
                $this->success('批量删除成功！','lst');
            }else{
                $this->error('批量删除失败！');
            }
        }else{
            $this->error('未选中内容！');
        }
    }

    //批量删除父权限之前先删除子权限
    public function bdelsonpri()
    {
        $ids = input('ids/a');
        $pri = new PrivilegeModel();
        $sonids = $pri->getchildid($ids);
        if ($sonids){
            db('privilege')->delete($sonids);
        }
    }
}