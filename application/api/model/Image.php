<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/13
 * Time: 19:48
 */

namespace app\api\model;


use think\Model;

class Image extends Model
{
    protected $hidden = ['id','from','update_time','delete_time'];

}