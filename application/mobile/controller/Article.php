<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/20
 * Time: 16:59
 */

namespace app\mobile\controller;

class Article extends Base
{
    public function index()
    {
        $arid = input('arid');
        $arts = db('article')->find($arid);
        $cateT = db('cate')->field('type')->where('id',$arts['cateid'])->find();
        $this->assign('cateT',$cateT);
        $this->assign('arts',$arts);
        //上一页
        $front = db('article')->where('id','<',$arid)->where('cateid',$arts['cateid'])->order('id desc')->limit('1')->find();
        if ($front){
            $furl = request()->controller().'/index/arid/'.$front['id'];
            $fname = $front['title'];
        }else{
            $furl = "javascript:void(0);";
            $fname = "没有数据了";
        }
        //下一页
        $after = db('article')->where('id','>',$arid)->where('cateid',$arts['cateid'])->order('id asc')->limit('1')->find();
        if ($after){
            $aurl = request()->controller().'/index/arid/'.$after['id'];
            $aname = $after['title'];
        }else{
            $aurl = "javascript:void(0);";
            $aname = "没有数据了";
        }
        $this->assign('front',$front);
        $this->assign('after',$after);
        $this->assign('furl',$furl);
        $this->assign('aurl',$aurl);
        $this->assign('fname',$fname);
        $this->assign('aname',$aname);
        return $this->fetch();
    }
}