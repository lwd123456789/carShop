<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/1
 * Time: 10:19
 */

namespace app\admin\controller;

use app\admin\model\Link as LinkModel;
use app\admin\controller\Base;
use think\Loader;
class Link extends Base
{
    //列表
    public function lst()
    {
        $link = new LinkModel();
        if (request()->isPost()){
            $sorts = input('post.');
            foreach ($sorts as $k=>$v){
                $link->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功！','lst');
            return;
        }
        $linkres = $link->order('sort asc')->select();
        $this->assign('linkres',$linkres);
        return $this->fetch('lst');
    }

    //添加
    public function add()
    {
        if (request()->isPost()){
            //验证
            $data = input('post.');
            $validate = Loader::validate('Link');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $add = LinkModel::create($data);
            if ($add){
                $this->success('添加成功！','lst');
            }else{
                $this->error('添加失败！');
            }
            return;
        }
        return $this->fetch('add');
    }

    //编辑
    public function edit()
    {
        $link = new LinkModel();
        if (request()->isPost()){
            //验证
            $data = input('post.');
            $validate = Loader::validate('Link');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $save = $link->save($data,['id'=>$data['id']]);
            if ($save !== false){
                $this->success('修改成功！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;
        }
        $links = $link->find(input('id'));
        $this->assign('links',$links);
        return $this->fetch('edit');
    }

    //单个删除
    public function del()
    {
        $del = LinkModel::destroy(input('id'));
        if ($del){
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
            $del = db('link')->delete($id);
            if ($del){
                $this->success('批量删除成功！','lst');
            }else{
                $this->error('批量删除失败！');
            }
        }else{
            $this->error('未选中内容！');
        }
    }

    //更新排序
    public function sortlink()
    {
        $link = new LinkModel();
        foreach ($_POST as $id=>$sort){
            $link->where('id',$id)->setField('sort',$sort);
        }
        $this->success('成功更新顺序！','lst');
    }
}