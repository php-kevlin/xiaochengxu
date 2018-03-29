<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/20
 * Time: 16:28
 */

namespace app\api\service;


use think\Exception;

class Pay
{
    private $orderID;
    private $orderNO;
    function __construct($orderID)
    {
        if(!$orderID){
            throw new Exception('订单不允许为空');
        }
        $this->orderID=$orderID;
    }

    public function pay()
    {

    }

}