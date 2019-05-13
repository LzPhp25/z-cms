<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 10:32
 */

namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use app\admin\validate\AdminValidate;
use think\Db;
use think\facade\Request;
use think\facade\Session;

class User extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];
    public function index()
    {
        $user = model('user')->selectData([]);
        $this->assign(['user'=>$user]);
        return view();
    }
    public function add()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            if(!isset($data['group_id'])) return backInfo(3, '请选择权限组！',[], 201);
            (new AdminValidate())->checkData($data);
            $data['pass'] = md5( $data['pass']);
            $res = model('user')->allowField(true)->save($data);
            if ($res){
                return backInfo(0, '添加成功！',[], 201);
            }
        }
        $group = model('group')->selectData(['status'=>1], 'id,title');
        $this->assign('group', $group);
        return view();
    }
    public function status()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            if ($data['id'] == 1 ){
                return backInfo(1, '无权限！',[], 201);
            }
            if ($data['id'] == Session::get('uid')){
                return backInfo(1, '不能修改自己！',[], 201);
            }
            $data['operation'] ='status';
           // halt($data);
            $result = model('user')->editData($data);
            if ($result){
                return backInfo(0, '修改成功！',[], 201);
            }
        }
    }
    public function edit()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            if(!isset($data['group_id'])) return backInfo(3, '请选择权限组！',[], 201);
            (new AdminValidate())->checkData($data);
            $data['pass'] = md5($data['pass']);
            $data['operation'] = 'update';
            $res = model('user')->editData($data);
            if ($res){
                return backInfo(0, '修改成功！',[], 201);
            }
        }
        $id = Request::param('id');
        $group = model('group')->selectData(['status'=>1], 'id,title');
        $data = Db::name('user')->where('id', $id)->find();
        $userGroup = Db::name('auth_group_access')->where('uid', $id)->column('group_id');

        $this->assign(
            ['userInfo'=>$data,'group'=>$group,'userGroup'=>$userGroup]
        );
        return view();
    }
    public function delete()
    {
        $id = Request::param('id');
        if ($id == 1){
            return backInfo(1, '不能删除此管理员！',[], 200);
        }
        $user = Session::get('user');
        $uid = $user['id'];
        if ($id == $uid){
            return backInfo(1, '不能删除此管理员！',[], 200);
        }
        $res = model('user')->delData($id);
        if ($res){
            return backInfo(0, '修改成功！',[], 200);
        }
    }
}