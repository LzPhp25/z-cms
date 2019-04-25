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

class Fore extends BaseController
{
    public function index()
    {
        $foreName = Db::name('fore')->where('id',1)->value('fore');
        $template = getDir('template');
        $this->assign([
            'fore'=>$template,
            'name'=>$foreName
        ]);
        return view();
    }

    public function setFore()
    {
        $data = Request::param('fore');
        $res = Db::name('fore')->where('id',1)->update(['fore'=>$data]);
        if ($res){
            return backInfo(0, '操作成功！',[], 201);
        }
    }

    public function fore()
    {
        $foreName = Db::name('fore')->where('id',1)->value('fore');
        $size = Request::param('size');
        $dir = "template/". $foreName.'/'.$size.'/';
        $data = scanFile($dir);
        $this->assign([
            'dir'=>$dir,
            'htmlList'=>$data,
            'size'=>$size,
        ]);
        return view();
    }

    public function delete()
    {
        $file = Request::param('file');
        @unlink($file);
        return backInfo(0, '操作成功！',[], 201);
    }

    public function makeFile()
    {
        $data = Request::param();
        $size = $data['size'];
        $newFile = $data['forename'];
        $foreName = Db::name('fore')->where('id',1)->value('fore');
        $dir = "template/". $foreName.'/'.$size.'/';
        $list = scanFile($dir);
        if (in_array($newFile, $list)){
            return backInfo(1, '文件已存在！',[], 201);
        }
        fopen($dir.$newFile,'w');
        return backInfo(0, '操作成功！',[], 201);
    }

    public function edit()
    {
        $file = Request::param('file');
        $size = Request::param('size');
        $data = file_get_contents($file);
        $this->assign([
            'data'=>$data,
            'file'=> $file,
            'size'=> $size,
        ]);
        return view();
    }

    public function editFore()
    {
        $data = Request::param();
        $filename = $data['file'];
        $content = $data['content'];
        file_put_contents($filename, '');
        file_put_contents($filename, $content);
        $this->success('编辑成功！');
    }
}