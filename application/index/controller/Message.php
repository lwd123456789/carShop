<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/12
 * Time: 19:47
 */

namespace app\index\controller;

use think\Loader;
use think\captcha\Captcha;
class Message extends Base
{
    public function index()
    {
        if (request()->isPost()){
            $data = input('post.');
            //字段验证
            $validate = Loader::validate('Message');
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
            $data['time'] = time();
            $add = db('message')->insert($data);
            if ($add){
                $this->success('留言成功！');
            }else{
                $this->error('留言失败！');
            }
            return;
        }
        $mres = db('message')->where('checked',1)->select();
        $this->assign('mres',$mres);
        $rpres = db('reply')->select();
        $this->assign('rpres',$rpres);
        return $this->fetch();
    }
}