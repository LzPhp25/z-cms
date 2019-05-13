<?php
namespace app\admin\controller;

use app\admin\common\Controller\BaseController;
use think\Db;
class Backup extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];
    public function index()
    {
        //获取操作内容：（备份/下载/还原/删除）数据库
        $type=input('type');
        //获取需要操作的数据库名字
        $name=input('name');
      //  halt($type);
        $backup = new \org\Baksql(Db::getConfig());
        switch ($type) {
            //备份
            case "backup":
                $info = $backup->backup();
                return  backInfo(0,$info,[],200);
                break;
            //下载
            case "dowonload":
                $info = $backup->downloadFile($name);
                return $info;
                break;
            //还原
            case "restore":
                $info = $backup->restore($name);
                return  backInfo(0,$info,[],200);
                break;
            //删除
            case "del":
                $info = $backup->delfilename($name);
                return  backInfo(0,'删除成功！',[],201);
                break;
            //如果没有操作，则查询已备份的所有数据库信息
            default:
               // halt(array_reverse($backup->get_filelist()));
                return $this->fetch("index", ["list" => array_reverse($backup->get_filelist())]);//将信息由新到老排序
        }

    }

}
