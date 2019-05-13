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
use think\Db;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;
use think\Image;

class BaseController extends Controller
{
    public $prefix;//表前缀
    public $system ;
    public function initialize()
    {
        $this->system = System::get(1);
        $this->prefix = Config::get('database.prefix');
        $this->noLogin();
        $this->loginOverTime();
        $this->loginIpValidate();
        parent::initialize();
    }

    public function loginOverTime()
    {
        if (Session::get('user_time') < time()){
            Session::delete('user');
            Session::delete('user_time');
            Session::delete('login_ip');
            $this->error('登陆超时，请重新登录！','admin/login/index');
        }else{
            Session::set('user_time',time()+3600);
        }
    }

    public function noLogin()
    {
        if(!Session::has('user')){
            $this->redirect('admin/login/index');
        }
    }

    public function loginIpValidate()
    {
        $login_site = $this->system['login_site'];
        if ($login_site == 1){
            $user = Session::get('user');
            $uid = $user['id'];
            $login_ip = Db::name('user')->where('id',$uid)->value('login_ip');
            if ($login_ip != Session::get('login_ip')){
                //检验帐号异地登录下线
                Session::delete('user');
                Session::delete('user_time');
                Session::delete('login_ip');
                $this->error('该账户已【'.$login_ip.'】登录！','admin/login/index');
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    public function auth()
    {
        $model = Request::module();
        $controller = Request::controller();
        $action = Request::action();
        $node = $model.'/'.$controller.'/'.$action;
        //halt($node);
        $user = Session::get('user');
        $uid = $user['id'];
        $auth = new Auth();
        $result = $auth->check($node, $uid);
        if ($result){
            return true;
        }else{
            return true;
          //return $this->redirect('admin/Index/authPage');
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