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
use app\admin\validate\SiteValidate;
use think\facade\Config;
use think\facade\Request;
use \app\admin\model\ConfigField as ConfigFieldModel;
class ConfigField extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['index'],
    ];
    public function index()
    {
        $fieldList =ConfigFieldModel::order('create_time','DESC')->paginate(Config::get('cms.page'));
        $this->assign('fieldList',$fieldList);
        return view();
    }

    public function addField()
    {
        return view();
    }

    public function add ()
    {
        $data = Request::param();
        (new SiteValidate())->checkData($data);
        $field = new ConfigFieldModel();
        $res = $field->save($data);
        if ($res){
            return backInfo(0, '添加成功！',[], 201);
        }
    }
    public function editField()
    {
        $id = Request::param('id');
        $fieldData =ConfigFieldModel::get($id);
        $this->assign('fieldData',$fieldData);
        return view();
    }
    public function update()
    {
        $data = Request::param();
        (new SiteValidate())->checkData($data);
        $field = new ConfigFieldModel();
        $res = $field->isUpdate(true)->save($data);
        if ($res){
            return backInfo(0, '编辑成功！',[], 201);
        }
    }

    public function delete()
    {
        $id = Request::param('id');
        $res = ConfigFieldModel::destroy($id);
        if ($res){
            return backInfo(0, '删除成功！',[], 201);
        }else{
            return backInfo(1, '删除失败！',[], 201);
        }
    }

}