<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/15
 * Time: 17:37
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code=404;


    public $msg='指定的类目不存在，请检查参数';


    public $errorCode = 41000;
}