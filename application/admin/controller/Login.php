<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 10:32
 */

namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use think\facade\Request;
use think\facade\Route;
use think\facade\Session;
use app\admin\model\User as UserModel;
class Login extends BaseController
{
    public function initialize()
    {
       $this->alreadyLogin();
    }

    public function alreadyLogin()
    {
        if (Session::has('user')){
            $this->redirect('admin/index/index');
        }
    }

    public function index()
    {
        return view();
    }

    public function login()
    {
        $data = Request::param();
        $user = UserModel::where('username',$data['username'])->where('status',1)->find();
        if ($user == null){
            return backInfo(2, '不存在该用户',[], 201);
        }elseif($user->pass != md5($data['password'])){
            return backInfo(1, '密码错误！',[], 201);
        }else{
            $user->isUpdate(true)->save(['login_time'=>time(),'login_ip'=>Request::ip(),'operation'=>'login']);
            $user->setInc('login_count', 1);
            Session::set('user',$user->toArray());
            Session::set('user_time',time()+3600);
            Session::set('login_ip',Request::ip());
            return backInfo(0, '登陆成功！',[], 201);
        }
    }

}