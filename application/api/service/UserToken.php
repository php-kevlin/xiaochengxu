<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/16
 * Time: 11:28
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppId;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppId = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppId,$this->wxAppSecret,$this->code);
    }

    public function get()
    {
        $result = curl_get($this->wxLoginUrl);

        $wxResult = json_decode($result,true);
        if(empty($wxResult))
        {
            throw new Exception('获取sesssion_key及openId时异常，微信内部错误');
        }else{
            $loginFail = array_key_exists('errcode',$wxResult);
            if($loginFail){
                $this->processLoginError($wxResult);
            }else{
                return $this->grantToken($wxResult);
            }
        }


    }
    private function grantToken($wxResult)
    {
        //拿到openid
        $openid = $wxResult['openid'];

        //到数据库看一下这个openID是否存在
            $user = UserModel::getByOpenId($openid);
        //如果存在，则不处理，如果不存在，新增一条user记录
        if($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        //生成令牌，准备缓存数据，写入缓存
        //key:令牌  value:wxResult,uid,scope
        $cacheValue = $this->prepareCacheValue($wxResult,$uid);
        $token = $this->saveToCache($cacheValue);
        return $token;
        //把令牌返回到客户端去
    }

    private function saveToCache($cacheValue)
    {
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config('setting.token_expire_in');
        $request = cache($key,$value,$expire_in);
        if(!$request)
        {
            throw new TokenException([
               'msg'=>'服务器缓存异常',
               'errCode'=>'10041'
            ]);
        }
        return $key;
    }
    private function prepareCacheValue($wxResult,$uid)
    {
        $cacheValue = $wxResult;
        $cacheValue['uid']= $uid;
        //scope = 16
       $cacheValue['scope'] = ScopeEnum::User;

        return $cacheValue;
    }


    private function newUser($openid)
    {
        $user = UserModel::create([
           'openid'=>$openid
        ]);
        return $user->id;
    }
    private function processLoginError($wxResult)
    {
        throw new WeChatException([
           'msg'=>$wxResult['errmsg'],
            'code'=>$wxResult['errcode']
        ]);
    }

}