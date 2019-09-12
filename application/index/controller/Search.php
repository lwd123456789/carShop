<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/19
 * Time: 19:42
 */

namespace app\index\controller;

class Search extends Base
{
    public function index()
    {
        $kws=input('kws');
        $cateid=input('cateid');
        $where1['title'] = ['like','%' . $kws . '%'];
        $where2['cateid'] = ['like','%' . $cateid . '%'];
        $lists = db('article')
            ->order('id desc')
            ->where($where1)
            ->where($where2)
            ->select();
        $this->assign(array(
            'lists'=>$lists,
        ));
        if ($cateid==69){
            $view = 'list';
        }elseif ($cateid==63 || $cateid==70){
            $view = 'carlist';
        }elseif ($cateid==67){
            $view = 'rylist';
        }
        return $this->fetch($view);
    }
}