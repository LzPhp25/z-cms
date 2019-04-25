<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 10:11
 */

namespace app\admin\common\Exception;


class ReturnException extends BaseException
{
    public $code = 1; //http错误码
    public $msg = '操作失败';  //自定义信息
    public $httpCode = 400; //自定义错误码
}