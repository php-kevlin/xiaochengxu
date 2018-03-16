<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/16
 * Time: 11:24
 */

namespace app\api\model;


class User extends BaseModel
{
    public static function getByOpenId($openid)
    {
        $user = self::where('openid','=',$openid)->find();
        return $user;

    }

}