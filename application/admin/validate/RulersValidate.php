<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
class RulersValidate extends BaseValidate
{
    protected $rule = [
        'title'=>'require|unique:auth_rule',
        'name'=>'require|unique:auth_rule',
        '__token__'=>'require|token',
    ];
    protected $message = [
        'title.require'=>'请填写规则名称',
        'title.unique'=>'规则名称已存在',
        'name.unique'=>'节点已存在',
        'name.require'=>'请填写节点',

    ];
}