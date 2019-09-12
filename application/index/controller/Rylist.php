<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/12
 * Time: 19:29
 */

namespace app\index\controller;

class Rylist extends Base
{
    public function index()
    {
        $cateid = input('cateid');
        $lists = db('article')->where('cateid',$cateid)->order('time desc')->select();
        $this->assign('lists',$lists);
        return $this->fetch();
    }
}