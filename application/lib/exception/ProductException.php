<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/15
 * Time: 12:17
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code=404;


    public $msg='指定的商品不存在，请检查参数';


    public $errorCode = 20000;
}