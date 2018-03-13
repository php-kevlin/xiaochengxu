<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/2/8
 * Time: 20:44
 */
namespace app\api\validate;
use think\Validate;
class TestValidate extends Validate
{
    protected $rule=[
        'name'=>'require|max:1',
        'email'=>'email'
    ];
}