<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/9
 * Time: 16:12
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    //HTTP 状态么
    public $code=400;

    //错误具体信息
    public $msg='参数错误';

    //自定义状态码
    public $errorCode = 10000;


}