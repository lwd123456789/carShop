<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/7/31
 * Time: 16:34
 */

namespace app\admin\controller;

use app\admin\model\Cate as CateModel;
use app\admin\model\Article as ArticleModel;
use app\admin\controller\Base;
use think\Loader;
class Article extends Base
{
    //列表
    public function lst()
    {
        $cate = new CateModel();
        $cates = $cate->catetree();
        $this->assign('cates',$cates);
        $artres = db('article')->alias('a')->join('cs_cate c','a.cateid=c.id')->field('a.*,c.name')->order('a.id desc')->select();
        $this->assign('artres',$artres);
        return $this->fetch('lst');
    }

    //添加
    public function add()
    {
        $article = new ArticleModel();
        if (request()->isPost()){
            $data = input('post.');
            $data['time']=time();
            //验证
            $validate = Loader::validate('Article');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            if ($article->save($data)){
                $this->success('添加成功！','lst');
            }else{
                $this->error('添加失败！');
            }
            return;
        }
        $cate = new CateModel();
        $cates = $cate->catetree();
        $this->assign('cates',$cates);
        return $this->fetch('add');
    }

    //编辑
    public function edit()
    {
        $article = new ArticleModel();
        if (request()->isPost()){
            $data = input('post.');
            //验证
            $validate = Loader::validate('Article');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $save = $article->save($data,['id'=>$data['id']]);
            if ($save !== false){
                $this->success('修改成功！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;
        }
        $articleres = $article->find(input('id'));
        $cate = new CateModel();
        $cates = $cate->catetree();
        $this->assign(array(
            'articleres'=>$articleres,
            'cates'=>$cates,
        ));
        return $this->fetch('edit');
    }

    //单个删除
    public function del()
    {
        $del = db('article')->delete(input('id'));
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
        $id = implode(',',$ids);
        if ($ids){
            $del = db('article')->delete($id);
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