<?php
namespace app\api\service;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\ForbiddenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken(){
        // 32个字符组成一组随机字符串
        $randChars = getRandChars(32);
        //用三组字符串，进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');

        $vars = Cache::get($token);

        if(!$vars)
        {
            throw new TokenException();
        }else{
            if(!is_array($vars))
            {
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars))
            {
                return $vars[$key];
            }else{
                throw new Exception('尝试获取的Token变量不存在');
            }


        }
    }

    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');

        return $uid;
    }

    /**
     * 需要用户和CMS管理员都可以访问的权限
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    /**
     * 只有用户才能访问的权限
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if($scope) {
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    public static function verifyToken($token)
    {
        $exits = Cache::get('token');
        if($exits){
            return true;
        }else{
            return false;
        }

    }

}