<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/28
 * Time: 10:50
 */

namespace app\api\validate;


class PagingParameter extends BaseValidate
{
    protected $rule = [
      'page'=>'isPositiveInteger',
        'size'=>'isPositiveInteger'
    ];
    protected $message = [
        'page'=>'分页参数必须是正整数',
        'size'=>'分页参数必须是正整数'
    ];

}