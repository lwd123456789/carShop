<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/12
 * Time: 19:53
 */

namespace app\index\controller;

class Article extends Base
{
    public function index()
    {
        $arid = input('arid');
        $articles = db('article')->find($arid);
        $this->assign('articles',$articles);
        //上一页
        $front = db('article')->where('id','<',$arid)->where('cateid',$articles['cateid'])->order('id desc')->limit('1')->find();
        if ($front){
            $furl = request()->controller().'/index/arid/'.$front['id'];
        }else{
            $furl = "javascript:void(0);";
        }
        //下一页
        $after = db('article')->where('id','>',$arid)->where('cateid',$articles['cateid'])->order('id asc')->limit('1')->find();
        if ($after){
            $aurl = request()->controller().'/index/arid/'.$after['id'];
        }else{
            $aurl = "javascript:void(0);";
        }
        $this->assign('front',$front);
        $this->assign('after',$after);
        $this->assign('furl',$furl);
        $this->assign('aurl',$aurl);
        return $this->fetch();
    }
}