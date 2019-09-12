<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/20
 * Time: 17:07
 */

namespace app\mobile\controller;

use think\Loader;
use think\captcha\Captcha;
class Message extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function addmsg()
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

    public function getInfo($p)
    {
        $perpage = 5; //每页显示数量
        $offset = ($p-1)*$perpage; //从第几条开始查找
        $msges = "";
        $data = array();
        $data['message'] = db('message')->where('type',0)->where('checked',1)->limit($offset,$perpage)->select();
        $data['reply'] = db('reply')->select();
        foreach ($data['message'] as $k=>$v){
            $msges.=<<<HTMLSTR
<li>
    <div>游客留言：</div>
    <div>{$v['content']}</div>
HTMLSTR;
            foreach ($data['reply'] as $k1=>$v1) {
                if ($v1['mid']==$v['id']){
                    $msges .= <<<HTMLSTR
                <h2 class="common_color">管理回复：{$v1['content']}</h2>
HTMLSTR;
                }
            }
$msges.=<<<HTMLSTR
</li>
HTMLSTR;

        }
        echo json_encode($msges);
    }
}