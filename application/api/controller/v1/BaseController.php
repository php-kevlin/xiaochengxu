<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/18
 * Time: 7:59
 */

namespace app\api\controller\v1;


use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
        protected function checkPrimaryScope()
        {
            TokenService::needPrimaryScope();
        }

    protected function checkExclusiveScope()
    {
            TokenService::needExclusiveScope();
    }
}