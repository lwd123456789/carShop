<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/12
 * Time: 20:02
 */

namespace app\index\controller;

use think\Loader;
use think\captcha\Captcha;
class Job extends Base
{
    public function index()
    {
        if (request()->isPost()){
            $data = input('post.');
            //字段验证
            $validate = Loader::validate('Job');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            //验证码验证
            $captcha = new Captcha();
            if (!$data['code']){
                $this->error('请输入验证码！');
            }
            if (!$captcha->check($data['code'])){
                $this->error('验证码错误！');
            }
            //添加
            $add = db('job')->insert($data);
            if ($add){
                $this->success('添加成功！');
            }else{
                $this->error('添加失败！');
            }
            return;
        }
        $arid = input('arid');
        $articles = db('article')->field('title')->find($arid);
        $this->assign('title',$articles['title']);
        return $this->fetch();
    }
}