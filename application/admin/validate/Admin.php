<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/1
 * Time: 20:28
 */

namespace app\admin\validate;

use think\Validate;
class Admin extends Validate
{
    protected $rule =   [
        'username'  => 'require|unique:admin',
        'password'  => 'require',
    ];

    protected $message  =   [
        'username.require' => '管理员名称不能为空',
        'username.unique' => '管理员名称不能重复',
        'password.require' => '管理员密码不能为空',
    ];

    protected $scene = [
        'add'  =>  ['username','password'],
        'edit'  =>  ['username'],
    ];
}