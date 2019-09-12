<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/22
 * Time: 19:26
 */

namespace app\mobile\controller;

class Search extends Base
{
    public function index()
    {
        $kws=input('kws');
        $count = db('article')->where('cateid',100)->where('title','like','%' . $kws . '%')->count();
        $this->assign('count',$count);
        return $this->fetch();
    }

    public function getInfo($p,$kws)
    {
        $perpage = 6; //每页显示数量
        $offset = ($p-1)*$perpage; //从第几条开始查找
        $data = db('article')->where('cateid',100)->where('title','like','%' . $kws . '%')->limit($offset,$perpage)->select();
        echo json_encode($data);
    }
}