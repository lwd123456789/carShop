<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/12
 * Time: 19:34
 */

namespace app\index\controller;

class Zplist extends Base
{
    public function index()
    {
        $cateid = input('cateid');
        $lists = db('article')->where('cateid',$cateid)->order('time desc')->select();
        $this->assign('lists',$lists);
        return $this->fetch();
    }
}