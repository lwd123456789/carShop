<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/21
 * Time: 15:43
 */

namespace app\mobile\controller;

use think\Controller;
class Base extends Controller
{
    public function _initialize()
    {
        //左侧栏目
        $cateid = input('cateid');
        $arid = input('arid');
        if ($arid){
            $articles = db('article')->field('cateid')->find($arid);
            $cateid = $articles['cateid'];
        }
        if ($cateid){
            $cates = db('cate')->field('name')->find($cateid);
            $catename=$cates['name'];
            $this->assign('catename',$catename);
        }
        //导航
        $this->getnav();
    }

    //导航
    public function getnav()
    {
        $cateres = db('cate')->where('pc',0)->order('id asc')->select();
        $this->assign('cateres',$cateres);
    }
}