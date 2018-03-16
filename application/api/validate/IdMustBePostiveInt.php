<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/2/17
 * Time: 17:08
 */
namespace app\api\validate;

class IdMustBePostiveInt extends BaseValidate
{
    protected $rule = [
      'id'=>'require|isPositiveInteger',
    ];

    protected $message = [
        'id' => 'id必须为正整数'
    ];




}