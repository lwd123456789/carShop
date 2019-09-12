<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/20
 * Time: 16:32
 */

namespace app\mobile\controller;

class Page extends Base
{
    public function index()
    {
        $cateid = input('cateid');
        $cates = db('cate')->field('content')->find($cateid);
        $catecont = $cates['content'];
        $this->assign('catecont',$catecont);
        return $this->fetch();
    }
}