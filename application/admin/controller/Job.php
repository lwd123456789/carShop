<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/17
 * Time: 8:52
 */

namespace app\admin\controller;

use app\admin\model\Job as JobModel;
class Job extends Base
{
    //列表
    public function lst()
    {
        $jobres = db('job')->field('id,title,name,sex,bplace,education')->select();
        $this->assign('jobres',$jobres);
        return $this->fetch('lst');
    }

    //查看
    public function detail()
    {
        $jobs = db('job')->find(input('id'));
        $this->assign('jobs',$jobs);
        return $this->fetch('detail');
    }

    //单个删除
    public function del()
    {
        $del = JobModel::destroy(input('id'));
        if ($del){
            $this->success('删除成功！','lst');
        }else{
            $this->error('删除失败！');
        }
    }

    //批量删除
    public function bdel()
    {
        $ids = input('ids/a');
        if ($ids){
            $id = implode(',',$ids);
            $del = db('job')->delete($id);
            if ($del){
                $this->success('批量删除成功！','lst');
            }else{
                $this->error('批量删除失败！');
            }
        }else{
            $this->error('未选中内容！');
        }
    }
}