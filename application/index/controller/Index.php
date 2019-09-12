<?php
namespace app\index\controller;

use think\Db;
class Index extends Base
{
    public function index()
    {
        //主要车型
        $mainres = db('article')->where('cateid',70)->field('id,title,pic,rizu')->order('id desc')->limit('3')->select();
        //车辆展示
        $carres = db('article')->where('cateid',63)->field('id,title,pic,rizu')->order('id desc')->limit('8')->select();
        //新闻资讯
        $arres = db('article')->where('cateid',69)->field('id,title,time')->order('id desc')->limit('3')->select();
        //左侧的主要车型
        $typeres = db('cate')->where('parentid',70)->field('name')->select();
        $this->assign(array(
            'mainres'=>$mainres,
            'carres'=>$carres,
            'arres'=>$arres,
            'typeres'=>$typeres,
        ));
        return $this->fetch();
    }

    //练习用的
    public function test()
    {
        //students为集合（相当于表）
        $test1=Db::connect("db_mongo")->name("students")->select();
        dump($test1);
    }
}
