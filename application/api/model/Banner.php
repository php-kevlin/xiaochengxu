<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/8
 * Time: 19:55
 */
namespace app\api\model;

use think\Db;
use think\Model;
use think\Exception;

class Banner extends Model
{
    protected $hidden = ['update_time','delete_time'];
    public function items()
    {
        return $this->hasMany('BannerItem','banner_id','id');
    }
    //protected $table='category';//设置模型关联的表名
    public static function getBannerById($id)
    {
        $banner=self::with(['items','items.img'])->find($id);
        return $banner;


        //TODO:根据BannerID号获取Banner信息
//        try{
//            1/0;
//        }catch (Exception $e){
//            throw $e;
//        }
        //return null;
//        $result  = Db::query('select * from banner_item where banner_id = ?',[$id]);
//表达式
//        $result = Db::table('banner_item')->where('banner_id','=',$id)
//            ->select();
//闭包
//        $result = Db::table('banner_item')
//         //   ->fetchSql()  //获取sql的执行语句
//            ->where(function ($query) use ($id){
//
//                $query->where('banner_id','=',$id);
//            })->select();



//        Db::table('banner_item');
//        Db::where('banner_id','=',$id);
//        $result = Db::select();
//        Db::select();//select 会清空状态
//        return $result;



    }
}