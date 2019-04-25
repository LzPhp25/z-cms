<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 17:33
 */
//权限操作类
namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use think\Db;
use think\facade\Request;
use app\admin\model\Photos as PhotosModel;
class Photos extends BaseController
{
    public function delete()
    {
        $id = Request::param('id');
        $photos = PhotosModel::get($id);
        @unlink($photos->img);
        $res = $photos->delete();
        if ($res){
            return backInfo(0, '删除成功！',[], 201);
        }
    }
}