<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/5
 * Time: 21:02
 */

namespace app\admin\validate;

use think\Validate;
class Role extends Validate
{
    protected $rule =   [
        'rolename'=>'require|unique:role',
    ];

    protected $message  =   [
        'rolename.require'=>'角色名称不能为空',
        'rolename.unique'=>'角色名称不能重复',
    ];

    protected $scene = [
        'add' => ['rolename'],
        'edit' => ['rolename'],
    ];
}