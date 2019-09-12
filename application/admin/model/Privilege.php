<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/2
 * Time: 16:53
 */

namespace app\admin\model;

use think\Model;
class Privilege extends Model
{
    public function pritree()
    {
        $prires = $this->select();
        return $this->sort($prires);
    }

    //递归方式进行无限极分类
    public function sort($data,$parentid=0,$level=0)
    {
        static $arr = array(); //静态化关键字static,否则每次递归都会将该数组初始化
        foreach ($data as $k=>$v){
            if ($v['parentid']==$parentid){
                $v['level'] = $level;
                $arr[] = $v;
                $this->sort($data,$v['id'],$level+1);
            }
        }
        return $arr;
    }

    //通过父权限获取所有子权限
    public function getchilrenid($priid)
    {
        $prires = $this->select();
        return $this->_getchilrenid($prires,$priid);
    }

    //获取所有父权限下的子权限
    public function _getchilrenid($prires,$priid)
    {
        static $arr = array();
        foreach ($prires as $k=>$v){
            if ($v['parentid']==$priid){
                $arr[] = $v['id'];
                $this->_getchilrenid($prires,$v['id']);
            }
        }
        return $arr;
    }

    //批量通过父权限获取所有子权限
    public function getchildid($ids)
    {
        $prires = $this->select();
        return $this->_getchildid($prires,$ids);
    }

    //批量获取所有父权限下的子权限
    public function _getchildid($prires,$ids)
    {
        static $arr = array();
        foreach ($prires as $k=>$v){
            foreach ($ids as $k1=>$v1){
                if ($v['parentid']==$v1){
                    $arr[] = $v['id'];
                    $this->_getchilrenid($prires,$v['id']);
                }
            }
        }
        return $arr;
    }
}