<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2019/7/31
 * Time: 17:09
 */

namespace app\admin\validate;

use think\Validate;
class Article extends Validate
{
    protected $rule =   [
        'title'=>'require|unique:article',
    ];

    protected $message  =   [
        'title.require'=>'文章标题不能为空',
        'title.unique'=>'文章标题不能重复',
    ];

    protected $scene = [
        'add' => ['title'],
        'edit' => ['title'],
    ];
}