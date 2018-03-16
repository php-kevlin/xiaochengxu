<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/14
 * Time: 12:20
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['delete_time','update_time','topic_img_id','head_img_id'];
        public function topicImg()
        {
            return $this->belongsTo('Image','topic_img_id','id');
        }

        public function headImage()
        {
        return $this->belongsTo('Image','head_img_id','id');
        }

        public function products()
        {
            return $this->belongsToMany('Product','theme_product','product_id','theme_id');
        }

        public static function getThemeWithProducts($id)
        {
            $thems = self::with('products,topicImg,headImage')->find($id);
            return $thems;
        }


}