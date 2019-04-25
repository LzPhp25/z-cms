<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 9:52
 */

namespace app\admin\common\Controller;
use app\admin\common\lib\Auth;
use app\admin\model\System;
use think\Controller;
use think\facade\Config;
use think\facade\Request;
use think\Image;

class BaseController extends Controller
{
    public $prefix;//表前缀
    public $system ;
    public function initialize()
    {
        $this->system = System::get(1);
        $this->prefix = Config::get('database.prefix');
        parent::initialize();
    }

    public function auth()
    {
        $model = Request::module();
        $controller = Request::controller();
        $action = Request::action();
        $node = $model.'/'.$controller.'/'.$action;
        //halt($node);
        $auth = new Auth();
        $result = $auth->check($node, 100);
        if ($result){
            return true;
        }else{
            return true;
            //return $this->redirect('admin/Index/auth');
        }
    }

    /**
     * 上传图片可设置水印
     * @param string $name
     * @param string $path
     * @return \think\response\Json
     */
    public function uploadImg($name ='file',$path='uploads/image/')
    {
        $file = request()->file($name);
        // 移动到框架应用根目录目录下
        //halt($this->system['image_size']);
        $info = $file->validate(['size'=>$this->system['image_size'],'ext'=>$this->system['image_type']])->move($path);
        if($info){
            $img = $path.date('Ymd').'/'.$info->getFilename();
            $image = Image::open($img);
            //halt($image);
            if ($this->system['is_code'] == 1){
                $codePath =$this->system['code_south'];
                $image->water($this->system['image_code'],$codePath,$this->system['image_issue'])->save($img);
            }
            if ($this->system['is_code'] == 2){
                $codePath =$this->system['code_south'];
                $image->text($this->system['text_code'],'static/admin/ttf/AlbanyWTJ.ttf',$this->system['text_size'],$this->system['text_color'],$codePath)->save($img);
            }
            return json(['code'=>0,'img'=>$img]);
        }else{
            // 上传失败获取错误信息
            //echo $file->getError();
            return json(['code'=>1,'message'=>$file->getError()]);
        }

    }

    /**
     * 上传文件
     * @param string $name
     * @param string $path
     * @return \think\response\Json
     */
    public function uploadDocumentFile($name ='file',$path='uploads/file/')
    {
        $file = request()->file($name);
        $info = $file->validate(['size'=>$this->system['file_size'],'ext'=>$this->system['file_type']])->move($path);
        if($info){
            $document = $path.date('Ymd').'/'.$info->getFilename();
            return json(['code'=>0,'img'=>$document]);
        }else{
            // 上传失败获取错误信息
            //echo $file->getError();
            return json(['code'=>1,'message'=>$file->getError()]);
        }
    }

    /**
     * 不会添加任何水印的原始上传
     * 但会对类型大小进行验证 主要用于栏目 水印 等图片上传
     * @param string $name
     * @param string $path
     * @return \think\response\Json
     */
    public function originalUploadImage($name ='file',$path='uploads/image/')
    {
        $file = request()->file($name);
        $info = $file->validate(['size'=>$this->system['image_size'],'ext'=>$this->system['image_type']])->move($path);
        if($info){
            $document = $path.date('Ymd').'/'.$info->getFilename();
            return json(['code'=>0,'img'=>$document]);
        }else{
            // 上传失败获取错误信息
            //echo $file->getError();
            return json(['code'=>1,'message'=>$file->getError()]);
        }
    }


}