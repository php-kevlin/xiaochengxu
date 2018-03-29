<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/17
 * Time: 16:25
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
        protected $rule = [
          'name'=>'require|isNotEmpty',
            'mobile'=>'require',//|isMobile
            'province'=>'require|isNotEmpty',
            'city'=>'require|isNotEmpty',
            'country'=>'require|isNotEmpty',
            'detail'=>'require|isNotEmpty',

        ];
}