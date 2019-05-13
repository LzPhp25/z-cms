<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
class SiteValidate extends BaseValidate
{
    protected $rule =[
        'cn_name'=>'require|chsAlpha|max:30|unique:config_field',
        'en_name'=>'require|alphaDash|max:20|unique:config_field',
    ];
    protected $message = [
        'cn_name.require'=>'请填写字段的中文名称',
        'cn_name.chsAlpha'=>'字段的中文名称只能为汉字和字母',
        'cn_name.max'=>'字段的中文名称长度不能超过30',
        'cn_name.unique'=>'该中文名称已存在',
        'en_name.require'=>'请填写字段的英文名称',
        'en_name.alpha'=>'字段的英文名称只能为字母',
        'en_name.max'=>'字段的英文名称长度不能超过30',
        'en_name.unique'=>'该英文名称已存在',
    ];
}