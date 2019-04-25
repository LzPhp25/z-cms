<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 10:32
 */

namespace app\admin\controller;
use app\admin\common\Controller\BaseController;
use app\admin\validate\ArticleValidate;
use think\Db;
use think\facade\Config;
use think\facade\Request;
use app\admin\model\Article as ArticleModel;
class Article extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['index'],
    ];
    public function index()
    {
        $cid = Request::param('id');
        $this->assign(['cid'=>$cid]);
        return view();
    }

    public function getPage()
    {
        $data = Request::param();
        $condition[] = ['cate_id','=' , $data['id']];
        $page = max($data['page'], 1);
        $data['limit'] ? $limit = $data['limit']: $limit = Config::get('cms.page');
        $field="id,title,attr,picture,sort,click,create_time";
        $articleList = model('article')->getPageData($condition, $page, $limit,$field);
        $tableName = Db::name('cate')->where('id', $data['id'])->value('cate_name');
        foreach ($articleList as $value){
            $value['cate'] = $tableName;
        }
        $count =  model('article')->dataCount($condition);
        return backPageInfo(0,'',$count, $articleList);
    }

    public function add()
    {
        $cid = Request::param('cid');
        $attrList = Db::name('attr')->field('attr_name,attr_value')->select();
        $cate = new Cate();
        $pattern = $cate->getPatternTable($cid);
        $addFieldData = Db::name($pattern['add_table'])->select();
       // halt($addFieldData);
        $this->assign([
            'attrList'=>$attrList,
            'cateId'=>$cid,
            'confList'=>$addFieldData,
            'pattern_id'=>$pattern['id'],
        ]);
        return view();
    }

    public function addArticle()
    {
        $data = Request::param();
        if ($data['photos'] == 1 && !isset($data['photo_list'])){
            return   ['code'=>3,'message'=>"请添加相册"];
        }
        (new ArticleValidate())->checkData($data);
        $data['create_time'] = strtotime($data['create_time']);
        foreach ($data as $key=>$value){
            if (is_array($value)){
                $data[$key] = implode(',',$value);
            }
        }
        $res = model('article')->allowField(true)->save($data);
        if ($res){
            return backInfo(0, '添加成功！',[], 201);
        }
    }

    public function upload()
    {
        return $this->uploadImg('file', 'uploads/article/');
    }

    public function edit()
    {
        $id = Request::param('id');
        $articleInfo = Db::name('article')->where('id',$id)->find();
        $attrList = Db::name('attr')->field('attr_name,attr_value')->select();
        $articleInfo['create_time'] = date('Y-m-d H:i:s',$articleInfo['create_time']);
        isset( $articleInfo['attr']) ? $articleInfo['attr'] = explode(',',$articleInfo['attr']): $articleInfo['attr'] = null;
        $articleInfo['photos'] ==1 ?  $photosData = Db::name('photos')->where('art_id', $id)->select():$photosData = [];
        $addFieldData = $this->getSubmeterData($articleInfo['pattern_id'], $id);
        $this->assign(
            [
                'attrList'=>$attrList,
                'articleInfo'=>$articleInfo,
                'confList'=>$addFieldData,
                'photosList'=>$photosData,
            ]
        );
        return view();
    }

    public function getSubmeterData($pattern_id, $aid)
    {
        $cate = new Cate();
        $pattern =Db::name('pattern')->where('id', $pattern_id)->find();
        $addFieldData = Db::name($pattern['add_table'])->select();
        $submeterData = Db::name($pattern['table_name'])->where('art_id', $aid)->find();
        foreach ($addFieldData as $key=>$value){
            foreach ($submeterData as $k=>$v){
                if ($value['en_name'] == $k){
                    $addFieldData[$key]['value'] = $v;
                }
            }
        }
       return $addFieldData;
    }

    public function editArticle()
    {
        $data = Request::param();
        if ($data['photos'] == 1 && !isset($data['photo_list'])){
            return   ['code'=>3,'message'=>"请添加相册"];
        }
        (new ArticleValidate())->checkData($data);
        if(isset($data['attr'])){
            $data['attr'] = implode(',',$data['attr']);
        }else{
            $data['attr'] = null;
        }
        $data['create_time'] = strtotime($data['create_time']);
        $data['operation'] = 'update';
        foreach ($data as $key=>$value){
            if (is_array($value)){
                $data[$key] = implode(',',$value);
            }
        }
        $res = model('article')->allowField(true)->isUpdate(true)->save($data);
        if ($res){
            return backInfo(0, '编辑成功！',[], 201);
        }
    }

    public function delete()
    {
        $data = Request::param('id');
        $res = ArticleModel::destroy($data);
        if ($res){
            return backInfo(0, '删除成功！',[], 201);
        }
    }

    public function sort()
    {
        $data = Request::param();
        $res= Db::name('article')->where('id', $data['id'])->update(['sort'=>$data['sort']]);
        if ($res){
            return backInfo(0, '操作成功！',[], 201);
        }
    }

    public function listTable()
    {
        $data = Request::param();
        $condition = [];
        $query = [];
        if (!empty($data['start']) && !empty($data['end'])){
            $condition[] = ['create_time','>',strtotime($data['start'])];
            $condition[] = ['create_time','<',strtotime($data['end'])];
            $query[] = ['start'=>strtotime($data['start'])];
            $query[] =['end'=>strtotime($data['end'])];
        }
        if (!empty($data['title'])){
            // $title = $data['title'] ;
            $condition[] = ['title','like','%'.$data['title'].'%'];
            $query[] =[ 'title'=>$data['title']];
        }
        $articleList = model('article')->with('cate')->where($condition)->paginate(10, false,['query'=>$data]);
        $attrList = Db::name('attr')->field('attr_name,attr_value')->select();
        $count = $articleList->count();
        $this->assign([
            'articleList'=>$articleList,
            'attrList'=>$attrList,
            'count'=>$count,
        ]);
        return $this->view->fetch();
    }

    public function addAttr()
    {
        $attr = Request::param();
        foreach ($attr['ids'] as $key=>$value){
            $attrValue = Db::name('article')->where('id',$value)->value('attr');
            if(!$attrValue){
                Db::name('article')->where('id',$value)->update(['attr'=>$attr['attr']]);
            }else{
                $attrString = explode(',',$attrValue);
                $attrString[] = $attr['attr'];
                $uniqueAttr = array_unique($attrString);
                $updateArr = implode(',',$uniqueAttr);
                Db::name('article')->where('id',$value)->update(['attr'=>$updateArr]);
            }
        }

        return backInfo(0, '操作成功！',[], 201);
    }

    public function cancelAttr()
    {
        $data = Request::param();
        foreach ($data['ids'] as $key=>$value){
            $attrValue = Db::name('article')->where('id',$value)->value('attr');
            if ($attrValue){
                $attrString = explode(',',$attrValue);
                foreach ($attrString as $k=>$v){
                    if ($v == $data['attr']){
                        unset($attrString[$k]);
                    }
                }
                $updateArr = implode(',',$attrString);
                Db::name('article')->where('id',$value)->update(['attr'=>$updateArr]);
            }
        }
        return backInfo(0, '操作成功！',[], 201);
    }


}