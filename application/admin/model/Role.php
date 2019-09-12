<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/5
 * Time: 20:41
 */

namespace app\admin\model;

use think\Model;
class Role extends Model
{
    //删除
    public function delrole($id)
    {
        $res = $this::destroy($id);
        if ($res){
            return 1;
        }else{
            return 2;
        }
    }
}