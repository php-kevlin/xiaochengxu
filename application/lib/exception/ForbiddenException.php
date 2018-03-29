<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/17
 * Time: 20:49
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code=403;


    public $msg='权限不够';


    public $errorCode = 10000;
}