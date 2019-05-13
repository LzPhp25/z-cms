<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 10:32
 */

namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use think\Db;
use think\facade\Request;
use app\admin\model\Message as MessageModel;
class Message extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];

    public function index()
    {
        $messageList = Db::name('message')->paginate(10);
        $this->assign('messageList',$messageList);
        return view();
    }
    public function delMessage()
    {
        if (Request::isAjax(true)){
            $data = Request::param('id');
            $res = MessageModel::destroy($data);
            if ($res){
                return backInfo(0, '删除成功！',[], 201);
            }else{
                return backInfo(1, '删除失败！',[], 201);
            }
        }
    }
    public function changeMessageShow()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            if($data['show'] == 1){
                Db::name('message')->where('id',$data['mid'])->update(['show'=>0]);
                return backInfo(0, '修改成功！',[], 201);
            }else{
                Db::name('message')->where('id',$data['mid'])->update(['show'=>1]);
                return backInfo(0, '修改成功！',[], 201);
            }
        }
    }

}