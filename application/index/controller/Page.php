<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/11
 * Time: 20:55
 */

namespace app\index\controller;

class Page extends Base
{
    public function index()
    {
        $cateid = input('cateid');
        $cates = db('cate')->find($cateid);
        $this->assign('cates',$cates);
        return $this->fetch();
    }
}