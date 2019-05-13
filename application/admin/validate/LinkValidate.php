<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
class LinkValidate extends BaseValidate
{
    protected $rule =[
        'link_name'  => 'require',
        'link_href'=>'require|url',
    ];
    protected $message = [
        'link_href.url'  => '网址格式不正确！',
        'link_name.require'  => '请填写链接名称',
        'link_href.require'  => '请填写链接地址',
    ];
}