<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/14
 * Time: 22:02
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code=404;


    public $msg='指定的主题不存在，检查主题id';


    public $errorCode = 30000;

}