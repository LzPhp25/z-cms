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
use \app\admin\model\ConfigField as ConfigFieldModel;
use think\Db;
use think\facade\Request;

class Conf extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];
    public function index()
    {
        $confList = ConfigFieldModel::all();
        $this->assign('confList',$confList);
        return view();
    }
    public function uploadImage()
    {
        return $this->uploadImg('image', 'uploads/site/image/');
    }

    public function uploadDocument()
    {
        return $this->uploadDocumentFile('file', 'uploads/site/file/');
    }
    public function inputData()
    {
        if (Request::isAjax(true)){
            $data = Request::post();
            unset($data['file']);
            unset($data['image']);
            foreach ($data as $key=>$value){
                if (is_array($value)){
                    $data[$key] = implode(',',$value);
                }
            }
            $checkData =  Db::name('config_field')->where('field_type',3)->find();
            if ($checkData){
                Db::name('config_field')->where('field_type',3)->update(['value'=>'']);
            }
            foreach ($data as $key=>$value){
                Db::name('config_field')->where('en_name',$key)->update(['value'=>$value]);
            }
            return json(['code'=>0,'message'=>'保存成功！']);
        }
    }

}