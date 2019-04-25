<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 11:19
 */

namespace app\admin\model;
use app\admin\common\model\BaseModel;
use think\Db;
use \app\admin\controller\Cate as CateController;
use think\facade\Request;

class Article extends BaseModel
{
    protected $table = 'lz_article';
    protected $pk = 'id';
    public function getAttrAttr($value)
    {
        if ($value){
             $arr = explode(',', $value);
             $str = "";
             $attr = ['r'=>'推荐','h'=>'热门','t'=>'头条','s'=>'置顶',];
             foreach ($arr as $k=>$v){
                foreach ($attr as  $a=>$b){
                    if ($a==$v){
                        $str.= "【".$attr[$a]."】";
                    }
                }
             }
             return $str;
        }else{
            return "【暂无属性】";
        }
    }
    public function getPictureAttr($value)
    {
        if ($value){
            return  "<a target='_blank' href='/".$value."'><img src='/".$value."'/><a>";
        }else{
            return "【暂无缩略图】";
        }
    }
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d H:i:s', $value);
    }
    public function cate()
    {
        return $this->belongsTo('cate')->field('id,cate_name');
    }
    public static function init()
    {
        $cate = new CateController();
        $photos = new Photos();
        self::event('after_insert', function ($article) use ($cate, $photos){
            $data = Request::param();
            if ($data['photos'] == 1){
                $photoList = array();
                foreach ($data['photo_list'] as $key => $value){
                    $photoList[] = ['img'=>$value,'art_id'=>$article['id']];
                }
                $photos->saveAll($photoList);
            }
            foreach ($data as $key=>$value){
                if (is_array($value)){
                    $data[$key] = implode(',',$value);
                }
            }
            $pattern = $cate->getPatternTable($article['cate_id']);
            $fieldTable = Db::name($pattern['add_table'])->column('en_name');
            $arr = array();
            foreach ($data as $key=>$value){
                if (in_array($key, $fieldTable)){
                    $arr[$key] = $data[$key];
                }
            }
            $arr['art_id'] = $article->id;
            Db::name($pattern['table_name'])->insert($arr);
        });
        self::event('after_update', function ($article) use ($cate, $photos){
            if ($article['operation'] == 'update'){
                $data = Request::param();
                if ($data['photos'] == 1){
                    $photoList = array();
                    foreach ($data['photo_list'] as $key => $value){
                        $photoList[] = ['img'=>$value,'art_id'=>$data['id']];
                    }
                    $photos->where('art_id',$data['id'])->delete();
                    $photos->saveAll($photoList);
                }else{
                    $photos->where('art_id',$data['id'])->delete();
                }
                foreach ($data as $key=>$value){
                    if (is_array($value)){
                        $data[$key] = implode(',',$value);
                    }
                }
                $pattern = $cate->getPatternTable($article['cate_id']);
                $fieldTable = Db::name($pattern['add_table'])->column('en_name');
                $check = Db::name($pattern['add_table'])->where('field_type',3)->select();
                if ($check){
                    foreach ($check as $key=>$value){
                        Db::name($pattern['table_name'])->where('art_id',$article['id'])->update([$value['en_name']=>'']);
                    }
                }
                $arr = array();
                foreach ($data as $key=>$value){
                    if (in_array($key, $fieldTable)){
                        $arr[$key] = $data[$key];
                    }
                }
                Db::name($pattern['table_name'])->where('art_id',$article['id'])->update($arr);
            }
        });
        self::event('after_delete', function ($article){
            if ($article['photos'] == 1){
                Db::name('photos')->where('art_id', $article['id'])->delete();
            }
            $table = Db::name('pattern')->where('id', $article['pattern_id'])->value('table_name');
            Db::name($table)->where('art_id',$article['id'])->delete();
        });
    }


}