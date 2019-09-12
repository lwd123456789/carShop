<?php
namespace app\mobile\controller;

class Index extends Base
{
    public function index()
    {
        //车辆展示
        $cares = db('article')->where('cateid',100)->limit(6)->select();
        //客户评价
        $msgres = db('message')->where('type',0)->limit(5)->select();
        $this->assign('msgres',$msgres);
        $this->assign('cares',$cares);
        return $this->fetch();
    }
}
