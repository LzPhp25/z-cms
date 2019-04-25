<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
class CateValidate extends BaseValidate
{
    protected $rule = [
        'cate_name'  => 'unique:cate',
        '__token__'=>'require|token',
    ];

    protected $message=[
        'cate_name.unique'  => '此栏目名已经存在！',
    ];
}