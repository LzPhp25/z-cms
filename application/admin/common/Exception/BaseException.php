<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 9:41
 */

namespace app\admin\common\Exception;
use think\Exception;
class BaseException extends Exception
{
    public $code = 1; //自定义错误码
    public $msg = '参数错误';  //自定义信息
    public $httpCode = 400; //http错误码
    public function __construct($param = [])
    {
        if (!is_array($param)){
            return ;
        }
        if (array_key_exists('code',$param)){
            $this->code = $param['code'];
        }
        if (array_key_exists('msg',$param)){
            $this->msg = $param['msg'];
        }
        if (array_key_exists('httpCode',$param)){
            $this->httpCode = $param['httpCode'];
        }
    }
}