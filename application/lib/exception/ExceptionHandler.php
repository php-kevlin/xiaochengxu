<?php
/**
 * Created by PhpStorm.
 * User: 张凯凯
 * Date: 2018/3/8
 * Time: 21:18
 */
namespace app\lib\exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //需要返回当前客户端返回的URL路径
    public function render(\Exception $e)
    {
        //如果是自定义的异常
        if($e instanceof BaseException)     //instanceof用于确定一个PHP变量是否属于某一类class的实类
        {
           $this->code= $e->code;
           $this->msg = $e->msg;
           $this->errorCode = $e->errorCode;
        }else{

            if(config('app_debug'))
            {
                return parent::render($e);
            }else {
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = '999';
                $this->recordErrorLog($e);

            }
        }

        $request = Request::instance();
        $result = [
            'msg'=>$this->msg,
            'error_code'=>$this->errorCode,
            'request_url'=>$request->url()
        ];
        return json($result,$this->code);

    }

    private function recordErrorLog(\Exception $e)
    {
        Log::init([
           'type'=>'File',
            'path'=>LOG_PATH,
            'lever'=>'error'
        ]);
        Log::record($e->getMessage(),'error');
    }

}