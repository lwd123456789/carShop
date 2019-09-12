<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/18
 * Time: 19:02
 */

namespace app\index\validate;

use think\Validate;
class Message extends Validate
{
    protected $rule =   [
        'nickname'  => 'require',
        'telephone'  => 'require',
        'email'  => 'require',
        'content'  => 'require',
    ];

    protected $message  =   [
        'nickname.require' => '姓名不能为空',
        'telephone.require' => '电话不能为空',
        'email.require' => '邮箱地址不能为空',
        'content.require' => '留言内容不能为空',
    ];
}