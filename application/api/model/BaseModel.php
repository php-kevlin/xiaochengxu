<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/14
 * Time: 11:20
 */

namespace app\api\model;


use think\Model;

class BaseModel extends Model
{
    protected function prefixImgUrl($value,$data)
    {
        $finaurl = $value;
        if($data['from']==1)

            $finaurl = config('setting.img_prefix').$value;
        else{
            $finaurl = $value;
        }
        return $finaurl;
    }

}