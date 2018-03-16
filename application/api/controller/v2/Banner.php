<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/1/23
 * Time: 11:09
 */

namespace app\api\controller\v2;

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



        return "This is v2 Version";





    }
}