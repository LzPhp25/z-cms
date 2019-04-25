<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
class PatternValidate extends BaseValidate
{
    protected $rule = [
        'name'=>'require|unique:pattern',
        'table_name'=>'require|alpha|unique:pattern',
        '__token__'=>'require|token',
    ];
    protected $message = [
        'name.require'=>'请填写模型名称',
        'name.unique'=>'模型名称已存在',
        'table_name.unique'=>'附加表已存在',
        'table_name.require'=>'请填写附加表',
        'table_name.alpha'=>'附加表名称必须为英文',

    ];
}