<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 9:47
 */

namespace app\admin\common\Validate;
use app\admin\common\Exception\BaseException;
use think\Validate;
class BaseValidate extends Validate
{
    public function checkData($param)
    {
        $result = $this->check($param);
        if (!$result){
            $e = new BaseException(['code'=>3,'msg'=>$this->error,'httpCode'=>200]);
            throw $e;
        }else{
            return true;
        }
    }
}