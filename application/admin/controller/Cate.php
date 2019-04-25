<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 17:34
 */
//权限组
namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use \app\admin\model\ConfigField as ConfigFieldModel;
use app\admin\validate\CateValidate;
use think\Db;
use think\facade\Request;
use app\admin\model\Cate as CateModel;

class Cate extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['index'],
    ];

    /**
     * @return \think\response\View
     */
    public function index()
    {
        $cateList = model('cate')->getInfiniteCate();
        foreach ($cateList as $key=>$value){
            $sonId = model('cate')->getCateExistSonCate($value['id']);
            $cateList[$key]['angle'] = $sonId;
        }
        $this->assign('cateList',$cateList);
        return view();
    }

    /**
     * @return \think\response\Json|\think\response\View
     * @throws \app\admin\common\Exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            //halt($data);
            if ($data['temp_type'] == 3 &&  empty($data['out_url'])){
                return backInfo(1, '请添加链接内容！',[], 201);
            }
            if ($data['temp_type'] != 3){
                $data['out_url'] ="";
            }
            (new CateValidate())->checkData($data);
            $res = model('cate')->save($data);
            if ($res){
                return backInfo(0, '添加成功！',[], 201);
            }
        }
        $pattern = $this->getPatternList();
        $this->assign([
            'pattern'=>$pattern,
        ]);
        return view();
    }

    /**
     * @return \think\response\View
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addSonCate()
    {
        $pid = Request::param('id');
        $pattern = $this->getPatternList();
        $this->assign([
            'pattern'=>$pattern,
            'pid'=>$pid,
        ]);
        return view();
    }

    /**
     * @return \think\response\Json|\think\response\View
     * @throws \app\admin\common\Exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            if ($data['temp_type'] == 3 &&  empty($data['out_url'])){
                return backInfo(1, '请添加链接内容！',[], 201);
            }
            if ($data['temp_type'] != 3){
                $data['out_url'] ="";
            }
            (new CateValidate())->checkData($data);
            $data['operation'] = 'update';
            $res = model('cate')->allowField(true)->isUpdate(true)->save($data);
            if ($res){
                return backInfo(0, '编辑成功！',[], 201);
            }
        }
        $id = Request::param('id');
        $cateInfo = model('cate')->where('id', $id)->find();
        $pattern = $this->getPatternList();
        $this->assign(
            [
                'cateInfo'=>$cateInfo,
                'pattern'=>$pattern,
            ]
        );
        return view();
    }

    /**
     * @return \think\response\Json
     */
    public function cateImage()
    {
        return $this->originalUploadImage('file', 'uploads/cate/');
    }

    /**
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPatternList()
    {
        $data = Db::name('pattern')->where('status', 1)->field('id,name,selected')->select();
        return $data;
    }

    /**
     * @return \think\response\Json
     */
    public function sort()
    {
        $data =Request::param('sort');
        $sort = array();
        foreach ($data as $key=>$value){
            if (!empty($value)){
                $sort[] = ['id'=>$key,'cate_sort'=>$value,'operation'=>'sort'];
            }
        }
        $res = model('cate')->editData($sort, 'all');
        if ($res){
            return backInfo(0, '排序成功！',[], 201);
        }

    }

    /**
     * @return \think\response\Json
     */
    public function status()
    {
        $data = Request::param();
        $id = intval($data['id']);
        $val = intval($data['val']);
        $val == 1 ? $change = ['id'=>$id, 'cate_status'=>0]:$change = ['id'=>$id, 'cate_status'=>1];
        $change['operation'] = 'status';
        $res = model('cate')->editData($change);
        if ($res){
            return backInfo(0, '修改成功！',['status'=>$val], 201);
        }
    }

    /**
     * @return \think\response\Json
     */
    public function delete()
    {
        $id = Request::param('id');
        $cate = new CateModel();
        if (is_array($id)){
            $sonId = $this->ifDeleteIdIsArray($id, $cate);
        }else{
            $sonId = $cate->getSonCateId($id);
            $sonId[] = $id;
        }
        $res = model('cate')->delData($sonId);
        if ($res){
            return backInfo(0, '删除成功！',[], 201);
        }
    }

    /**
     * @param $id
     * @param $cate
     * @return array
     */
    public function ifDeleteIdIsArray($id, $cate)
    {
        $arr = [];
        foreach ($id as $key=>$value){
            $arr[] =  $cate->getSonCateId($value);
            $arr[] = $id[$key];
        }
        $newArr = [];
        foreach ($arr as $key=>$value){
            if (is_array($value)){
                foreach ($value as $k=>$v){
                    $newArr[] = $v;
                }
            }else{
                $newArr[] = $value;
            }
        }
        foreach ($newArr as $key=>$value){
            $newArr[$key] = intval($value);
        }
        $sonId = array_unique($newArr);
        return $sonId;
    }

    /**
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function copy()
    {
        $id = Request::param('id');
        $cateData = Db::name('cate')->where('id', $id)->hidden(['id'])->find();
        $cateData['cate_name'] = $cateData['cate_name'].($cateData['copy']+1);
        $cateData['copy'] = 0;
        $insertCateId = Db::name('cate')->insertGetId($cateData);
        Db::name('cate')->where('id', $id)->setInc('copy');
        $sonId = model('cate')->getSonCateId($id);
        if (count($sonId) > 0) $this->copySonCate($sonId, $insertCateId);
        if ($insertCateId){
            return backInfo(0, '复制栏目成功！',[], 201);
        }

    }

    /**
     * @param $sonId
     * @param $insertCateId
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function copySonCate($sonId, $insertCateId)
    {
        foreach ($sonId as $key=>$value){
            $cateData = Db::name('cate')->where('id', $value)->hidden(['id'])->find();
            $cateData['cate_name'] = $cateData['cate_name'].($cateData['copy']+1);
            $cateData['cate_pid'] = $insertCateId;
            $cateData['copy'] = 0;
            Db::name('cate')->insert($cateData);
        }
    }

    /**
     * @param $cid
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getPatternTable($cid)
    {
        $patternId = Db::name('cate')->where('id', $cid)->value('pattern_id');
        $data = Db::name('pattern')->where('id', $patternId)->field('id,name,table_name,add_table')->find();
        return $data;
    }
}