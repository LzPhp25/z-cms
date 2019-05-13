<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 10:32
 */

namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use think\facade\Session;

class Index extends BaseController
{
    public function index()
    {
        return view();
    }
    public function welcome()
    {
        return view();
    }
    public function authPage()
    {
        return view('auth');
    }

    public function loginOut()
    {
        Session::delete('user');
        Session::delete('user_time');
        Session::delete('login_time');
        return backInfo(0, '退出登录！',[], 201);
    }
}