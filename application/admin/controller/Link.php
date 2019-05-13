<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 10:32
 */

namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use app\admin\model\Link as LinkModel;
use app\admin\validate\LinkValidate;
use think\facade\Request;

class Link extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];

    public function index()
    {
        $linkList = LinkModel::all();
        $this->assign('linkList',$linkList);
        return view();
    }

    public function add()
    {
        return view();
    }
    public function addLink()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            (new LinkValidate())->checkData($data);
            $addRes = LinkModel::create($data);
            if ($addRes){
                return backInfo(0, '添加成功！',[], 201);
            }else{
                return backInfo(1, '添加失败！',[], 201);
            }


        }
    }
    public function edit()
    {
        $id = Request::param('id');
        $link = LinkModel::get($id);
        $this->assign('link', $link );
        return view();
    }
    public function editLink()
    {
        $data = Request::param();
        (new LinkValidate())->checkData($data);
        $addRes = LinkModel::update($data);
        if ($addRes){
            return backInfo(0, '修改成功！',[], 201);
        }else{
            return backInfo(1, '修改失败！',[], 201);
        }
    }

    public function delAll()
    {
        if (Request::isAjax(true)){
            $data = Request::param('id');
            $res = LinkModel::destroy($data);
            if ($res){
                return backInfo(0, '删除成功！',[], 201);
            }else{
                return backInfo(1, '删除成功！',[], 201);
            }
        }
    }

}