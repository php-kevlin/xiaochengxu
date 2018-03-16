<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/15
 * Time: 17:14
 */

namespace app\api\model;


class Category extends BaseModel
{

    protected $hidden = ['create_time','update_time','delete_time'];
    public function Img()
    {
        return $this->belongsTo('Image','topic_img_id','id');
    }



}