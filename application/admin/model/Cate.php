<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/7/30
 * Time: 15:17
 */
namespace app\admin\model;

use think\Model;
class Cate extends Model
{
    public function catetree()
    {
        $cateres = $this->order('sort asc')->select();
        return $this->sort($cateres);
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

    //通过钩子函数上传图片
    protected static function init()
    {
        Cate::event('before_insert', function ($data) {
            //上传图片
            if ($_FILES['pic']['tmp_name']) {
                // 获取表单上传文件
                $file = request()->file('pic');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info) {
                    $pic = '/uploads/' . $info->getSaveName();
                    $data['pic'] = $pic;
                }
            }
        });
        //通过钩子函数修改图片
        Cate::event('before_update', function ($data) {
            //上传图片
            if ($_FILES['pic']['tmp_name']){
                $cates = Cate::find($data->id);
                $picpath = $_SERVER['DOCUMENT_ROOT'] . $cates['pic'];
                if (file_exists($picpath)){
                    @unlink($picpath);
                }
                // 获取表单上传文件
                $file = request()->file('pic');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if ($info){
                    $pic = '/uploads/' . $info->getSaveName();
                    $data['pic'] = $pic;
                }
            }
        });
        //通过钩子函数删除图片
        Cate::event('before_delete', function ($data) {
            $cates = Cate::find($data->id);
            $picpath = $_SERVER['DOCUMENT_ROOT'] . $cates['pic'];
            if (file_exists($picpath)){
                @unlink($picpath);
            }
        });
    }

    //通过父栏目获取所有子栏目
    public function getchilrenid($cateid)
    {
       $cateres = $this->select();
       return $this->_getchilrenid($cateres,$cateid);
    }

    //获取所有父栏目下的子栏目
    public function _getchilrenid($cateres,$cateid)
    {
        static $arr = array();
        foreach ($cateres as $k=>$v){
            if ($v['parentid']==$cateid){
                $arr[] = $v['id'];
                $this->_getchilrenid($cateres,$v['id']);
            }
        }
        return $arr;
    }

    //批量通过父栏目获取所有子栏目
    public function getchildid($ids)
    {
        $cateres = $this->select();
        return $this->_getchildid($cateres,$ids);
    }

    //批量获取所有父栏目下的子栏目
    public function _getchildid($cateres,$ids)
    {
        static $arr = array();
        foreach ($cateres as $k=>$v){
            foreach ($ids as $k1=>$v1){
                if ($v['parentid']==$v1){
                    $arr[] = $v['id'];
                    $this->_getchilrenid($cateres,$v['id']);
                }
            }

        }
        return $arr;
    }
}