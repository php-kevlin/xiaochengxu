<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/17
 * Time: 16:52
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code=404;


    public $msg='用户名不存在';


    public $errorCode = 60000;
}