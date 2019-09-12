<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/2
 * Time: 16:56
 */
namespace app\admin\validate;

use think\Validate;
class Privilege extends Validate
{
    protected $rule =   [
        'pri_name'=>'require|unique:privilege',
        'mname'=>'require',
        'cname'=>'require',
        'aname'=>'require',
    ];

    protected $message  =   [
        'pri_name.require'=>'权限名称不能为空',
        'pri_name.unique'=>'权限名称不能重复',
        'mname.require'=>'模块名称不能为空',
        'cname.require'=>'控制器名称不能为空',
        'aname.require'=>'方法名称不能为空',
    ];

    protected $scene = [
        'add' => ['pri_name','mname','cname','aname'],
        'edit' => ['pri_name','mname','cname','aname'],
    ];
}