<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/7
 * Time: 17:29
 */
namespace app\api\validate;
use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;
class BaseValidate extends Validate
{

        function goCheck()
        {
            //获取http传入的数据
            $request = Request::instance();
            $parms = $request->param();

            //对这些数据做校验

            $result = $this->batch()->check($parms);
            if(!$result)//如果传入的参数不正确
            {
                //第一种
                $e = new ParameterException([
                    'msg'=>$this->error
                ]);
                //第二种
//                $e = new ParameterException();
//                $e->msg = $this->error;
                throw $e;

//                throw new \Exception($error);
            }
        }

    protected function isPositiveInteger($value,$rule='',$data='',$field='')
    {

        if(is_numeric($value)&&is_int($value+0)&&($value+0)>0){
            return true;
        } else{
            return false;
//            return $field."必须是正整数";
        }
    }
}