<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/17
 * Time: 10:13
 */
namespace app\index\validate;

use think\Validate;
class Job extends Validate
{
    protected $rule =   [
        'name'  => 'require',
        'mobile'  => 'require',
    ];

    protected $message  =   [
        'name.require' => '姓名不能为空',
        'mobile.require' => '电话不能为空',
    ];
}