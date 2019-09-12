<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/20
 * Time: 16:40
 */

namespace app\mobile\controller;

class Arlist extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function getInfo($p)
    {
        $perpage = 5; //每页显示数量
        $offset = ($p-1)*$perpage; //从第几条开始查找
        $data = db('article')->where('cateid',98)->limit($offset,$perpage)->select();
        echo json_encode($data);
    }
}