<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 17:34
 */
//权限组
namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use app\admin\validate\RulersValidate;
use think\Db;
use think\facade\Request;
use app\admin\model\Rulers as RulersModel;
class Rulers extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];
    public function index()
    {
        $data = Db::name('auth_rule')->field('id,name,title')->paginate(15);
        $this->assign('rules', $data);
        return view();
    }

    public function add()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            $name =  $data['model'].'/'. $data['controller'].'/'. $data['action'];
            $newArray = array('title'=>$data['title'],'name'=>$name);
            (new RulersValidate())->checkData($newArray);
            $res = Db::name('auth_rule')->insert($newArray);
            if ($res){
                return backInfo(0, '添加成功！',[], 201);
            }
        }
        return view();
    }

    public function edit()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            $name =  $data['model'].'/'. $data['controller'].'/'. $data['action'];
            $newArray = array('title'=>$data['title'],'name'=>$name,'id'=>$data['id']);
            (new RulersValidate())->checkData($newArray);
            $res = model('rulers')->editData($newArray);
            if ($res){
                return backInfo(0, '编辑成功！',[], 201);
            }
        }
        $id = Request::param('id');
        $ruler = Db::name('auth_rule')->find($id);
        $ruler['name'] = explode('/', $ruler['name']);
       // halt($ruler);
        $this->assign('ruler', $ruler);
        return view();
    }

    public function delete()
    {
        $id = Request::param('id');
        $res = RulersModel::destroy($id);
        if ($res){
            return backInfo(0, '删除成功！',[], 201);
        }else{
            return backInfo(1, '删除失败！',[], 201);
        }
    }
}