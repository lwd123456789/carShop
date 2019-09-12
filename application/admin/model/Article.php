<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/7/31
 * Time: 17:06
 */

namespace app\admin\model;

use think\Model;
class Article extends Model
{
    //通过钩子函数上传图片
    protected static function init()
    {
        Article::event('before_insert', function ($data) {
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
        Article::event('before_update', function ($data) {
            //上传图片
            if ($_FILES['pic']['tmp_name']){
                $arts = Article::find($data->id);
                $picpath = $_SERVER['DOCUMENT_ROOT'] . $arts['pic'];
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
        Article::event('before_delete', function ($data) {
            $arts = Article::find($data->id);
            $picpath = $_SERVER['DOCUMENT_ROOT'] . $arts['pic'];
            if (file_exists($picpath)){
                @unlink($picpath);
            }
        });
    }
}