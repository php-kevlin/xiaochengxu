<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/28
 * Time: 21:43
 */

namespace app\api\model;


class ThirdApp extends BaseModel
{
    public static function check($ac,$se)
    {
        $app = self::where('app_id','=',$ac)
            ->where('app_secret','=',$se)
            ->find();
        return $app;
    }

}