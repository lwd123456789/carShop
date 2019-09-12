<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/1
 * Time: 16:23
 */

namespace app\admin\controller;

use think\Config;
use app\admin\controller\Base;
class System extends Base
{
    public function lst()
    {
        if (request()->isPost()){
            //array_change_key_case($_POST,CASE_UPPER) 将数组中的键改为大写
            $file = APP_PATH.'extra/myconfig.php';
            $info = Config::get('myconfig');
            $config = array_merge($info,array_change_key_case($_POST,CASE_UPPER));
            $str = "<?php\r\nreturn ".var_export($config,true)."; ?>";
            if (file_put_contents($file,$str)){
                $this->success('修改配置成功！','lst');
            }else{
                $this->success('修改配置失败！');
            }
            return;
        }
        return $this->fetch('lst');
    }
}