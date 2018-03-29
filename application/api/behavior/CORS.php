<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/29
 * Time: 20:02
 */

namespace app\api\behavior;


class CORS
{
    public function appInit(&$params)
    {
        header('Access-Control-Allow-Origin:*');//允许所有域名访问
        header('Access-Control-Allow-Headers:token,Origin,X-Requested-with，Content-Type,Accept');//允许其他域名访问时携带的数据
        header('Access-Control-Allow-Methods:POST,GET');
        if(request()->isOptions())
        {
            exit();
        }

    }
    /*public function appInit(&$params)
    {
        header('Access-Control-Allow-Origin: *');  //允许所有域访问API
        //允许header携带的键值对
        header("Access-Control-Allow-Headers: token, Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: POST,GET');
        if(request()->isOptions()){
            exit();
        }
    }*/

}