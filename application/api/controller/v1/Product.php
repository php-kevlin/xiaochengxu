<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/15
 * Time: 11:53
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use app\api\validate\IdMustBePostiveInt;
use app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;

class Product
{
    /**
     * 获取最近的商品
     */
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty())
        {
            throw new ProductException();
        }

        $collections = collection($products);
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id)
    {
        (new IdMustBePostiveInt())->goCheck();

        $products = ProductModel::getProductsByCategoryId($id);
        if($products->isEmpty())
        {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;

    }
}