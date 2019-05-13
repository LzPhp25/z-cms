<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
class AdminValidate extends BaseValidate
{
    protected $rule = [
        'username'=>'require|unique:user',
        'pass'=>'require',
    ];
    protected $message = [
        'username.require'=>'请填写帐号',
        'username.unique'=>'该账号已存在！',
        'pass.require'=>'请填写密码',

    ];
}