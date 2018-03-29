<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/28
 * Time: 21:31
 */

namespace app\api\validate;


class AppTokenGet extends BaseValidate
{
    protected $rule = [
      'ac'=>'require|isNotEmpty',
      'se'=>'require|isNotEmpty'
    ];
}