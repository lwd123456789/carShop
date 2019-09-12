<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/7/30
 * Time: 11:38
 */

namespace app\admin\controller;

use app\admin\model\Cate as CateModel;
use app\admin\controller\Base;
use think\Loader;
class Cate extends Base
{
    //删除的前置操作
    protected $beforeActionList = [
        'delsoncate' => ['only'=>'del'],
        'bdelsoncate' => ['only'=>'bdel'],
    ];

    //列表
    public function lst()
    {
        $cate = new CateModel();
        $cates = $cate->catetree();
        $this->assign('cates',$cates);
        return $this->fetch('lst');
    }

    //添加
    public function add()
    {
        $cate = new CateModel();
        if (request()->isPost()){
            $data = input('post.');
            //验证
            $validate = Loader::validate('Cate');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            if ($cate->save($data)){
                $this->success('添加成功！','lst');
            }else{
                $this->error('添加失败！');
            }
            return;
        }
        $cates = $cate->catetree();
        $this->assign('cates',$cates);
        return $this->fetch('add');
    }

    //编辑
    public function edit()
    {
        $cate = new CateModel();
        if (request()->isPost()){
            $data = input('post.');
            //验证
            $validate = Loader::validate('Cate');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $save = $cate->save($data,['id'=>$data['id']]);
            if ($save !== false){
                $this->success('修改成功！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;
        }
        $cates = $cate->catetree();
        $cateres = $cate->find(input('id'));
        $this->assign(array(
            'cates'=>$cates,
            'cateres'=>$cateres,
        ));
        return $this->fetch('edit');
    }

    //删除
    public function del()
    {
        $del = db('cate')->delete(input('id'));
        if ($del){
            $this->success('删除成功！','lst');
        }else{
            $this->error('删除失败！');
        }
    }

    //删除父栏目之前先删除子栏目
    public function delsoncate()
    {
        $cateid = input('id');
        $cate = new CateModel();
        $sonids = $cate->getchilrenid($cateid);
        if ($sonids){
            db('cate')->delete($sonids);
        }
    }

    //批量删除
    public function bdel()
    {
        $ids = input('ids/a');
        $id = implode(',',$ids);
        if ($ids){
            $del = db('cate')->delete($id);
            if ($del){
                $this->success('批量删除成功！','lst');
            }else{
                $this->error('批量删除失败！');
            }
        }else{
            $this->error('未选中内容！');
        }
    }

    //批量删除父栏目之前先删除子栏目
    public function bdelsoncate()
    {
        $ids = input('ids/a');
        $cate = new CateModel();
        $sonids = $cate->getchildid($ids);
        if ($sonids){
            db('cate')->delete($sonids);
        }
    }

    //更新排序
    public function sortcate()
    {
        $cate = new CateModel();
        foreach ($_POST as $id=>$sort){
            $cate->where('id',$id)->setField('sort',$sort);
        }
        $this->success('成功更新栏目顺序！','lst');
    }
}