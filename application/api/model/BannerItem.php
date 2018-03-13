<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/13
 * Time: 19:12
 */

namespace app\api\model;


use think\Model;

class BannerItem extends Model
{
    protected $hidden = ['id','img_id','banner_id','update_time','delete_time'];
    public function img()
    {
        return $this->belongsTo('Image','img_id','id');
    }


}