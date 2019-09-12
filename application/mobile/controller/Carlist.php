<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/20
 * Time: 16:49
 */

namespace app\mobile\controller;

class Carlist extends Base
{
    public function index()
    {
        $count = db('article')->where('cateid',100)->count();
        $this->assign('count',$count);
        return $this->fetch();
    }

    public function getInfo($p)
    {
        $perpage = 6; //每页显示数量
        $offset = ($p-1)*$perpage; //从第几条开始查找
        $data = db('article')->where('cateid',100)->limit($offset,$perpage)->select();
        echo json_encode($data);
    }
}