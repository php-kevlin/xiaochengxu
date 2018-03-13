<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/2/17
 * Time: 17:08
 */
namespace app\api\validate;

class IdMustBePostiveInt extends BaseValidate
{
    protected $rule = [
      'id'=>'require|isPositiveInteger',
    ];

    public function isPositiveInteger($value,$rule='',$data='',$field='')
    {

        if(is_numeric($value)&&is_int($value+0)&&($value+0)>0){
          return true;
        } else{
            return $field."必须是正整数";
        }
    }


}