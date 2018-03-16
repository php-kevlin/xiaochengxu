<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/14
 * Time: 12:15
 */

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\validate\IdMustBePostiveInt;
use app\lib\exception\ThemeException;
use app\api\model\Theme as ThemeModel;
class Theme {

    /**
     * @param string $ids
     * @url /theme?ids=id1,id2,id3......
     * @return 一组theme模型
     */
    public function getSimpleList($ids='')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::with(['topicImg','headImage'])->select($ids);
        if($result->isEmpty())
        {
            throw new ThemeException();
        }
        return $result;
    }

    public function getComplexOne($id)
    {
        (new IdMustBePostiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if(!$theme)
        {
            throw new ThemeException();
        }
        return $theme;
    }

}