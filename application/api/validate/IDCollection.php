<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/14
 * Time: 20:25
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
      'ids'=>'require|checkIDs'
    ];

    protected $message = [
      'ids'=>'ids参数必须是以逗号分隔的多个正整数'
    ];

    protected function checkIDs($value)
    {
        $values = explode(',',$value);
        if(empty($values))
        {
            return false;
        }
        foreach ($values as $id)
        {
            if(!$this->isPositiveInteger($id))
            {
                return false;
            }
        }
        return true;
    }

}