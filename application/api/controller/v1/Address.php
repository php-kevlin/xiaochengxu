<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/17
 * Time: 14:10
 */

namespace app\api\controller\v1;
use app\api\model\User as UserModel;
use app\api\model\UserAddress;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;

class Address extends BaseController
{
   protected $beforeActionList=[
        'checkPrimaryScope'=>['only'=>'createOrUpdateAddress,getUserAddress']
   ];

    public function createOrUpdateAddress()
    {
       // (new AddressNew())->goCheck();
        $validate = new AddressNew();
        $validate->goCheck();
        //根据token获取UID
        $uid = TokenService::getCurrentUid();
        //根据Uid查询用户数据，判断用户是否存在，如果不存在抛出异常
        $user = UserModel::get($uid);
        if(!$user) {
            throw new UserException();
        }
        //获取用户从客户端提交的地址信息
        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        //根据用户地址信息是否存在，从而判断是添加地址还是更新地址
        if(!$userAddress){
                $user->address()->save($dataArray);
        }else{
            $user->address->save($dataArray);
        }

        return json(new SuccessMessage(),201);
    }
    public function getUserAddress(){

        $uid = TokenService::getCurrentUid();
        $userAddress = UserAddress::where('user_id','=',$uid)->find();
        if(!$userAddress){
            throw new UserException([
               'msg'=>'用户地址不存在',
                'errorCode'=>60001
            ]);
        }
        return $userAddress;
    }

}