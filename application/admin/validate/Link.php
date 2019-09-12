<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/8/1
 * Time: 13:57
 */

namespace app\admin\validate;

use think\Validate;
class Link extends Validate
{
    protected $rule =   [
        'title'  => 'require|unique:link',
        'url'  => 'require|unique:link|url',
    ];

    protected $message  =   [
        'title.require' => '链接名称不能为空',
        'title.unique' => '链接名称不能重复',
        'url.require' => '链接地址不能为空',
        'url.unique' => '链接地址不能重复',
        'url.url' => '链接地址格式不正确',
    ];

    protected $scene = [
        'add'  =>  ['title','url'],
        'edit'  =>  ['title','url'],
    ];
}