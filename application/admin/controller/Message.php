<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/18
 * Time: 20:32
 */

namespace app\admin\controller;

use app\admin\model\Message as MessageModel;
use app\admin\model\Reply;
class Message extends Base
{
    //列表
    public function lst()
    {
        $message = new MessageModel();
        $messageres = $message->select();
        $this->assign('messageres',$messageres);
        return $this->fetch('lst');
    }

    //单个删除
    public function del()
    {
        $reply = new Reply();
        $del = MessageModel::destroy(input('id'));
        if ($del){
            //删除对应留言的所有回复
            $reply->where('mid',input('id'))->delete();
            $this->success('删除成功！','lst');
        }else{
            $this->error('删除失败！');
        }
    }

    //批量删除
    public function bdel()
    {
        $reply = new Reply();
        $ids = input('ids/a');
        $ides = $ids;
        if ($ids){
            $id = implode(',',$ids);
            $del = db('message')->delete($id);
            if ($del){
                foreach ($ides as $k=>$v){
                    //删除对应留言的所有回复
                    $reply->where('mid',$v)->delete();
                }
                $this->success('批量删除成功！','lst');
            }else{
                $this->error('批量删除失败！');
            }
        }else{
            $this->error('未选中内容！');
        }
    }

    //回复
    public function reply()
    {
        $reply = new Reply();
        if (request()->isPost()){
            $data = input('post.');
            $data['time'] = time();
            $save = $reply->save($data);
            if ($save !== false){
                $this->success('回复成功！','lst');
            }else{
                $this->error('回复失败！');
            }
            return;
        }
        $replyres = $reply->where('mid',input('id'))->select();
        $this->assign('replyres',$replyres);
        $message = new MessageModel();
        $messages = $message->find(input('id'));
        $this->assign('messages',$messages);
        return $this->fetch('reply');
    }

    //审核
    public function checked()
    {
        $message = new MessageModel();
        if (request()->isPost()){
            $data = input('post.');
            $save = $message->save($data,['id'=>$data['id']]);
            if ($save !== false){
                $this->success('审核通过！','lst');
            }else{
                $this->error('审核未通过！');
            }
            return;
        }
        $messages = $message->find(input('id'));
        $this->assign('messages',$messages);
        return $this->fetch('checked');
    }
}