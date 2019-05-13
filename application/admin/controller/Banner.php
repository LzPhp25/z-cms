<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 10:32
 */

namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use app\admin\validate\BannerValidate;
use think\Db;
use think\facade\Request;
use app\admin\model\Banner as BannerModel;

class Banner extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];

    public function index()
    {
        $bannerList = Db::name('banner')->alias('b')->leftJoin('cate c','b.cate_id = c.id')->field('b.*,c.cate_name')->select();
        //halt($bannerList);
        $this->assign('bannerList',$bannerList);
        return view();
    }
    public function add()
    {
        $topCate = Db::name('cate')->where('cate_pid',0)->select();
        $this->assign('topCate', $topCate );
        return view();
    }
    public function addBanner()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            (new BannerValidate())->checkData($data);
            $data['create_time'] = time();
            $addRes = BannerModel::create($data);
            if ($addRes){
                return backInfo(0, '添加成功！',[], 201);
            }else{
                return backInfo(1, '添加失败！',[], 201);
            }
        }
    }
    public function upload()
    {
        return $this->uploadImg('image', 'uploads/banner/' );
    }
    public function edit()
    {
        $id = Request::param('id');
        $banner = BannerModel::get($id);
        $topCate = Db::name('cate')->where('cate_pid',0)->select();
        $this->assign('banner', $banner );
        $this->assign('topCate', $topCate );
        return view();
    }
    public function editBanner()
    {
        $data = Request::param();
        (new BannerValidate())->checkData($data);
        $data['create_time'] = time();
        $addRes = BannerModel::update($data);
        if ($addRes){
            return backInfo(0, '修改成功！',[], 201);
        }else{
            return backInfo(1, '修改失败！',[], 201);
        }
    }
    public function delBanner()
    {
        if (Request::isAjax(true)){
            $data = Request::param('id');
            $res = BannerModel::destroy($data);
            if ($res){
                return backInfo(0, '删除成功！',[], 201);
            }else{
                return backInfo(0, '删除失败！',[], 201);
            }
        }
    }

    public function see()
    {
        $id = Request::param('id');
        $img = Db::name('banner')->where('id', $id)->value('banner_img');
        echo "<img src='/".$img."'";
    }



}