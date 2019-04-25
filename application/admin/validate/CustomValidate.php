<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 13:03
 */

namespace app\admin\validate;
use app\admin\common\Validate\BaseValidate;
use think\Db;

class CustomValidate extends BaseValidate
{
    protected $rule = [
        'cn_name'=>'require|chs|checkUnique',
        'en_name'=>'require|alpha|checkUnique',
        'length'=>'require|number',
        'table'=>'require',
        '__token__'=>'require|token',
    ];
    protected $message = [
        'cn_name.require'=>'请填写中文字段名',
        'cn_name.chs'=>'中文字段名只能是汉字',
        'cn_name.checkUnique'=>'该中文字段已存在',
        'en_name.require'=>'请填写英文字段名',
        'en_name.alpha'=>'英文字段名只能为英文字母',
        'en_name.checkUnique'=>'英文字段名已存在',
        'length.require'=>'请填写字段长度',
        'length.number'=>'字段长度只能为纯数字',
        'table.require'=>'非法请求',
    ];

    // 自定义验证规则
    protected function checkUnique($value,$rule,$data=[],$field='')
    {

        if (isset($data['id'])){
            $validate = Db::name($data['table'].'_field')->where([['id','<>',$data['id']],[$field,'=', $value]])->find();
            if ($validate){
                return false;
            }else{
                return true;
            }
        }else{
            $validate = Db::name($data['table'].'_field')->where($field, $value)->find();
            if ($validate){
                return false;
            }else{
                return true;
            }
        }

    }
}