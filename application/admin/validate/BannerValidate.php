<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
class BannerValidate extends BaseValidate
{
    protected $rule = [

        'banner_link'  => 'url',
        'banner_img'=>'require',
    ];
    protected $message=[
        'banner_link.url'  => '网址格式不正确！',
        'banner_img.require'  => '请上传轮播图',
    ];
}