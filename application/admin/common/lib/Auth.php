<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/12
 * Time: 13:29
 */

namespace app\admin\common\lib;
use think\Db;
use think\facade\Config;

class Auth
{
    public function check($node, $uid)
    {
        $groupIds = $this->getGroupId($uid);
        $ruler = $this->getRules($groupIds);
        $ruleName = $this->getRuleName($ruler);
        if (in_array($node, $ruleName)){
            return true;
        }else{
            return false;
        }
    }

    private function getGroupId($uid)
    {
        $data = Db::name('auth_group_access')->where('uid', $uid)->column('group_id');
        return $data;
    }

    private function getRules($groupId)
    {
        $data = Db::name('auth_group')->where(['id'=>$groupId])->column('rules');
        return $data;
    }

    private function getRuleName($array)
    {
        $newArray = array();
        foreach ($array as $key=>$value){
            $array[$key] = explode(',', $value);
        }
        foreach ($array as $key=>$value){
            foreach ($value as $k=>$v){
                $newArray[] = $v;
            }
        }
        $data =  Db::name('auth_rule')->where(['id'=>array_unique($newArray)])->column('name');
        $white = Config::get('auth.white');
        foreach ($white as $value){
            $data[] = $value;
        }
        return $data;
    }
}