<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/15
 * Time: 11:57
 */

namespace app\api\validate;


class Count extends BaseValidate
{
        protected $rule = [
          'count'=>'isNotEmpty|isPositiveInteger|between:1,15'
        ];
}