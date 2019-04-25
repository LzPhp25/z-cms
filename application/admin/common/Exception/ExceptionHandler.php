<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 9:40
 */

namespace app\admin\common\Exception;
use think\exception\Handle;
use think\facade\Config;
use think\facade\Log;
use think\facade\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $httpCode;
    public function render(\Exception $e)
    {
        if ($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->httpCode = $e->httpCode;
        }else{
            $switch = Config::get('app.app_debug');
            if ($switch){
                return parent::render($e);
            }else{
                $this->code = 999;
                $this->msg = '服务器内部错误！';
                $this->httpCode = 500;
                $this->recordErrorLog($e);
            }
        }
        $result = array(
            'code'=>$this->code,
            'message'=>$this->msg,
            'request_url'=>Request::url(),
        );
        return json($result,$this->httpCode);

    }
    private function recordErrorLog(\Exception $e)
    {
        Log::record($e->getMessage(),'error');
    }
}