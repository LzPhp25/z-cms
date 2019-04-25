<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
class ArticleValidate extends BaseValidate
{
    protected $rule = [
        'title'  => 'require|min:2|max:50',
        'sort'  => 'number',
        '__token__'=>'require|token',
    ];

    protected $message=[
        'title.require'  => '请填写标题',
        'title.min'  => '标题的长度不能小于2个字符',
        'title.max'  => '标题的长度不能大于50个字符',
        'sort.number'  => '排序必须为纯数字',
    ];
}