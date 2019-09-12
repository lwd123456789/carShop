<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/18
 * Time: 19:02
 */

namespace app\mobile\validate;

use think\Validate;
class Message extends Validate
{
    protected $rule =   [
        'nickname'  => 'require',
        'content'  => 'require',
    ];

    protected $message  =   [
        'nickname.require' => '标题不能为空',
        'content.require' => '留言内容不能为空',
    ];
}