<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/16
 * Time: 11:03
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
        protected $rule = [
          'code'=>'require'
        ];
        protected $message = [
            'code'=>'没有code还想获取token，做梦哦'
        ];
}