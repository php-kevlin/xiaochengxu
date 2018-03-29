<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/17
 * Time: 12:37
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden =[
      'img_id','delete_time','product_id'
    ];

    public function ImgUrl()
    {
        return $this->belongsTo('Image','img_id','id');
    }


}