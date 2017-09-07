<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/29
 * Time: 15:44
 */

namespace app\lib\exception;


use Exception;
use think\Config;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    //请求资源的url

    /**
     * @param Exception $e
     * @return \think\response\Json
     * 重写tp5的异常处理方法,自定义异常处理
     */
    public function render(Exception $e)
    {
        //判断是什么异常类型
        if($e instanceof BaseException) {
            //自定义的异常,用户行为导致的异常
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else {
            //服务器内部异常
            //Config::get('app_debug');
            if(config('app_debug')) {
                //return default error page
                return parent::render($e);
            }else {
                $this->code = '500';
                $this->msg = '服务器内部异常，不想告诉你!';
                $this->errorCode = '999';
                $this->recordErrorLog($e);
            }

        }
        $request = Request::instance();
        $result = [
            'code'=>$this->code,
            'msg'=>$this->msg,
            'errorCode'=>$this->errorCode,
            'request_url'=>$request->url()
        ];

        return json($result,$this->code);
    }

    /**
     * @param Exception $e
     * 记录错误异常，用户导致的异常无需记录日志，意义不大，
     * 服务器内部产生的异常需要记录到日志文件，排错
     * 生产环境下，只能通过日志来排查错误，测试环境下可以直接打断点排查错误
     */
    protected function recordErrorLog(Exception $e) {
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);
        Log::record($e->getMessage(),'error');
    }

}