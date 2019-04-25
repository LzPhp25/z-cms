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
use think\Db;
use think\facade\Request;
use \app\admin\model\Group as GroupModel;

class Group extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['index'],
    ];
    public function index()
    {
        $data = Db::name('auth_group')->field('id,title,rules')->paginate(15)->each(function ($item, $key){
            $item['rules'] = explode(',', $item['rules']);
            $item['rulesContent'] = "";
            foreach ( $item['rules'] as $k=>$v){
                $item['rulesContent'] .= '【'.Db::name('auth_rule')->where('id', $v)->value('title')."】";
            }
            unset($item['rules']);
            return $item;
        });
        $this->assign('group', $data);
        return view();
    }

    public function add()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
           if (!isset($data['rules'])){
               return backInfo(3, '请选择权限！',[], 201);
           }
           $data['rules'] = implode(',', $data['rules']);
           $res = Db::name('auth_group')->insert($data);
            if ($res){
                return backInfo(0, '添加成功！',[], 201);
            }
        }
        $ruleList = Db::name('auth_rule')->field('id, title')->select();
        $this->assign('rule', $ruleList);
        return view();
    }

    public function edit()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            if (!isset($data['rules'])){
                return backInfo(3, '请选择权限！',[], 201);
            }
            $data['rules'] = implode(',', $data['rules']);
            $res = Db::name('auth_group')->where('id', $data['id'])->update($data);
            if ($res){
                return backInfo(0, '添加成功！',[], 201);
            }
        }
        $id = Request::param('id');
        $group = Db::name('auth_group')->find($id);
        $group['rules'] = explode(',',$group['rules']);
        $ruleList = Db::name('auth_rule')->field('id, title')->select();
        $this->assign([
            'rule'=> $ruleList,
            'group'=> $group,
        ]);
        return view();
    }

    public function delete()
    {
        $id = Request::param('id');
        $res = GroupModel::destroy($id);
        if ($res){
            return backInfo(0, '删除成功！',[], 201);
        }else{
            return backInfo(1, '删除失败！',[], 201);
        }
    }

}