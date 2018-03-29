<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/20
 * Time: 16:32
 */

namespace app\api\controller\v1;


class Pay extends BaseController
{
    protected $beforeActionList=[
      'checkExclusiveScope'=>['only'=>'getPreOrder']
    ];

    public function getPreOrder($id = '')
    {

    }

}