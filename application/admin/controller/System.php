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
use think\facade\Request;

class System extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['index'],
    ];
    public function index()
    {
        $system = \app\admin\model\System::get(1);
        $this->assign('system',$system);
        return view();
    }

    public function waterImage()
    {
        return $this->originalUploadImage('file', 'uploads/water/');
    }

    public function saveSystem()
    {
        if(Request::isAjax(true)){
            $data = Request::post();
            unset($data['file']);
            $res = \app\admin\model\System::update($data);
            if($res){
                return json(['code'=>0,'message'=>'保存成功！']);
            }else{
                return json(['code'=>1,'message'=>'保存失败！']);
            }
        }
    }

}