<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/16
 * Time: 20:55
 */

namespace app\lib\exception;


class TokenException extends BaseException
{

    public $code=401;


    public $msg='token已经过期或者无效';


    public $errorCode = 999;
}