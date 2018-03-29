<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/19
 * Time: 20:59
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden =['user_id','delete_time','update_time'];
    protected $autoWriteTimestamp = true;
/*
 * 根据用户id查询订单
 */
    public static function getSummaryByUser($uid,$page=1,$size=4){
        $pagingData = self::where('user_id','=',$uid)
            ->order('create_time desc')
            ->paginate($size,true,['page'=>$page]);
        return $pagingData;
    }

    public function getSnapItemsAttr($value){

        return json_decode($value);
    }

    public function getSnapAddressAttr($value){

        return json_decode($value);
    }

    public static  function getSummaryByPage($page,$size){
        $pagingData = self::order('create_time desc')
            ->paginate($size,true,['page'=>$page]);
        return $pagingData;
    }
}