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
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];
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
        @$data = scanFile($dir);
        $data ? $templateData = $this->getSiteEndFile($data,'html') :$templateData =[];
        //halt($templateData);
        $this->assign([
            'dir'=>$dir,
            'htmlList'=>$templateData,
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

    public function style()
    {
        $foreName = Db::name('fore')->where('id',1)->value('fore');
        $cssdir = "template/". $foreName.'/pc/css/';
        $jsdir = "template/". $foreName.'/pc/js/';
        @$jsData = scanFile($jsdir);
        @$cssData = scanFile($cssdir);
        $cssData ? $css = $this->getSiteEndFile($cssData,'css'):$css =[];
        $jsData ? $js =  $this->getSiteEndFile($jsData,'js') : $js =[];
        $this->assign([
            'css'=>$css,
            'js'=>$js,
            'cssdir'=>$cssdir,
            'jsdir'=>$jsdir,
        ]);
        return view();
    }

    public function styleEdit()
    {
        if (Request::isPost()){
            $data = Request::param();
            $filename = $data['file'];
            $content = $data['content'];
            file_put_contents($filename, '');
            file_put_contents($filename, $content);
            $this->success('编辑成功！');
            return;
        }
        $file = Request::param('file');
        $data = file_get_contents($file);
        $this->assign([
            'data'=>$data,
            'file'=> $file,
        ]);
        return view();
    }

    /***
     * 获取指定尾缀的文件列表
     * return array
     */
    private function getSiteEndFile($data, $end)
    {
        $arr = array();
        foreach ($data as $key=>$value){
            $v = pathinfo($value);
            if ($v['extension'] == $end){
                $arr[] = $value;
            }
        }
        return $arr;
    }
}