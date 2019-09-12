<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/13
 * Time: 20:11
 */

namespace app\index\controller;

use think\Controller;
class Base extends Controller
{
    public function _initialize()
    {
        //左侧栏目
        $cateid = input('cateid');
        $arid = input('arid');
        if ($arid){
            $articles = db('article')->find($arid);
            $cateid = $articles['cateid'];
        }
        $this->getCates($cateid);
        //网站栏目导航
        $this->getNav();
        //找到自己的头部
        $this->selfTop($cateid);
        //找各级的父栏目
        $pres = $this->getparent($cateid);
        $this->assign('pres',$pres);
        //友情链接
        $this->link();
    }

    //友情链接
    public function link()
    {
        $linkres = db('link')->field('title,url')->select();
        $this->assign('linkres',$linkres);
    }

    //找各级的父栏目
    public function getparent($cateid)
    {
        $res = array();
        while ($cateid){
            $cates = db('cate')->find($cateid);
            $res[] = array(
                'id' => $cates['id'],
                'name' => $cates['name'],
                'type' => $cates['type'],
            );
            $cateid = $cates['parentid'];
        }
        return array_reverse($res);
    }

    //找到自己的头部
    public function selfTop($cateid)
    {
        $cates = db('cate')->find($cateid);
        if ($cates['class']==1){
            $selftop = $cates['name'];
        }elseif ($cates['class']==2){
            $cates = db('cate')->where('id',$cates['parentid'])->find(); //找到二级栏目
            $selftop = $cates['name'];
        }else{
            $cates = db('cate')->where('id',$cates['parentid'])->find(); //找到三级栏目
            $cates = db('cate')->where('id',$cates['parentid'])->find(); //找到二级栏目
            $selftop = $cates['name'];
        }
        $this->assign('selftop',$selftop);
    }

    //左侧栏目
    public function getCates($cateid=0)
    {
        if ($cateid){
            $cates = db('cate')->find($cateid);
            $catesons = db('cate')->where('parentid',$cates['id'])->select();
            if ($cates['parentid']==0 && !$catesons){
                $cates = db('cate')->where('id',63)->find();
            }
            if ($cates['class']==1){
                $son2 = db('cate')->where('parentid',$cates['id'])->select();
                $this->assign(array(
                    'son2'=>$son2,
                    'son3'=>null,
                    'topname'=>$cates['name'],
                    'son3pid'=>null,
                ));
            }
            if ($cates['class']==2){
                $topcates = db('cate')->where('id',$cates['parentid'])->find();
                $son2 = db('cate')->where('parentid',$topcates['id'])->select();
                $son3 = db('cate')->where('parentid',$cates['id'])->select();
                $this->assign(array(
                    'son2'=>$son2,
                    'son3'=>$son3,
                    'topname'=>$topcates['name'],
                    'son3pid'=>null,
                ));
            }
            if ($cates['class']==3){
                $upercates = db('cate')->where('id',$cates['parentid'])->find(); //三级栏目对应的二级栏目
                $topcates = db('cate')->where('id',$upercates['parentid'])->find();
                $son3 = db('cate')->where('parentid',$upercates['id'])->select();
                $son2 = db('cate')->where('parentid',$topcates['id'])->select();
                $this->assign(array(
                    'son2'=>$son2,
                    'son3'=>$son3,
                    'topname'=>$topcates['name'],
                    'son3pid'=>$upercates['id'],
                ));
            }
        }
    }

    //网站栏目导航
    public function getNav()
    {
        $where = array(
            'parentid'=>0,
            'pc'=>1,
        );
        $navres = db('cate')->field('id,name,type')->order('sort asc')->where($where)->select();
        $this->assign('navres',$navres);
    }
}