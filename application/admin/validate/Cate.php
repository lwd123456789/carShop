<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/7/30
 * Time: 15:53
 */
namespace app\admin\validate;

use think\Validate;
class Cate extends Validate
{
    protected $rule =   [
        'name'=>'require|unique:cate',
    ];

    protected $message  =   [
        'name.require'=>'栏目名称不能为空',
        'name.unique'=>'栏目名称不能重复',
    ];

    protected $scene = [
        'add' => ['name'],
        'edit' => ['name'],
    ];
}