<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 11:19
 */

namespace app\admin\model;
use app\admin\common\model\BaseModel;
use think\Db;

class Rulers extends BaseModel
{
    protected $table = 'lz_auth_rule';
    protected $pk = 'id';
    public static function init()
    {
        self::event('after_delete', function ($rules) {
            $id =(string)$rules['id'];
            //halt($id);
            $ruleArray = array();
            $groupRules =model('group')->field('id,rules')->select();
            foreach ($groupRules as $key=>$value){
                $ruleArray[$value['id']] = explode(',', $value['rules']);
            }
            foreach ($ruleArray as $key=>$value){
                foreach ($value as $k=>$v){
                    if ($v == $id ){
                        unset($ruleArray[$key][$k]);
                    }
                }
            }
            $editArray = array();
            foreach ($ruleArray as $key=>$value){
                $editArray[] = ['id'=>$key,'rules'=>implode(',', $value)];
            }
            model('group')->saveAll($editArray);
        });
    }

}