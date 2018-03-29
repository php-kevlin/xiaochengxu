<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/18
 * Time: 11:16
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code=404;


    public $msg='订单不存在，请检查ID';


    public $errorCode = 80000;
}