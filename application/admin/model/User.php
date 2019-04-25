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

class User extends BaseModel
{
    protected $table = 'lz_user';
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;
    protected $hidden = ['pass'];
    protected $insert=['status'=>1,'login_count'=>0,'login_ip'=>'0.0.0.0'];

    public static function init()
    {
        self::event('after_insert', function ($user) {
                $id = $user['id'];
                $group_id = $user['group_id'];
                $insertArray = array();
                foreach ($group_id as $key=>$value){
                    $insertArray[] = ['uid'=>$id,'group_id'=>$value];
                }
                model('access')->saveAll($insertArray);
        });
        self::event('after_update', function ($user) {
            if ($user['operation'] == 'update'){
                $id = $user['id'];
                $group_id = $user['group_id'];
                $insertArray = array();
                foreach ($group_id as $key=>$value){
                    $insertArray[] = ['uid'=>$id,'group_id'=>$value];
                }
                Db::name('auth_group_access')->where('uid', $id)->delete();
                model('access')->saveAll($insertArray);
            }else{
                return true;
            }
        });
        self::event('after_delete', function ($user) {
            $id = $user['id'];
            Db::name('auth_group_access')->where('uid', $id)->delete();
        });

    }

}