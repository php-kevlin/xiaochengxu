<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/1/23
 * Time: 11:09
 */

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IdMustBePostiveInt;
use app\lib\exception\BannerMissException;


class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @param $id
     */
    public function getBanner($id)
    {

        (new IdMustBePostiveInt())->goCheck();

            $banner = BannerModel::getBannerById($id);



            //1.数组
            /*$data = $banner->toArray();
            unset($data['delete_time']);*/
            //2.
            //$banner->hidden(['update_time']);
            //3.要显示的
            //$banner->visible(['id']);

            if(!$banner)
            {
              throw new BannerMissException();
//                throw new Exception('内部错误');
            }



        return $banner;



        //独立验证
//        $data = [
//          'id'=>$id,
//            ];
//
////        $validate = new Validate([
////            'id'=>$id,
////        ]);
//        $validate = new IdMustBePostiveInt();
//        //验证器
//       // $validate = new TestValidate();
//        //batch()批量验证
//        $result = $validate->batch()->check($data);
//       //var_dump($validate->getError());
//        if($result)
//        {
//
//        }else{
//
//        }
    }
}