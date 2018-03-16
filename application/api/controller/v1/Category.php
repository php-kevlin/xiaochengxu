<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/15
 * Time: 17:14
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;
use think\Exception;

class Category
{
    public function getAllCategories()
    {
        //$categories = CategoryModel::with(['Img'])->select();
        $categories = CategoryModel::all([],'Img');
        if(!$categories)
        {
            throw new CategoryException();
        }
        return $categories;
    }


}