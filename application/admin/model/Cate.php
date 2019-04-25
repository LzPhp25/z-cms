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

class Cate extends BaseModel
{
    protected $table = 'lz_cate';
    protected $pk = 'id';
    protected $autoWriteTimestamp = true;

    public static function init()
    {
        self::event('after_update', function ($cate) {
            //halt($cate);
            if ($cate['operation'] =='status') {
                $sonId = $cate->getSonCateId($cate['id']);
                if (count($sonId) > 0) {
                    foreach ($sonId as $key => $value) {
                        Db::name('cate')->where('id', $value)->update(['cate_status'=>$cate['cate_status']]);
                    }

                }
            }
        });
        self::event('before_delete', function ($cate) {
            Article::destroy(function ($query) use ($cate){
                    $query->where('cate_id', $cate['id']);
            });
        });
    }
    /**
     * 获取所有栏目的信息数据
     */
    public function getCateData()
    {
        $data = self::order('cate_sort','ASC')->field('id,cate_name,cate_pid,cate_sort,cate_status,temp_type')->select();
        return $data;
    }

    public function article()
    {
        return $this->hasMany('article','cate_id','id');
    }

    /**
     * 获取无限极栏目
     */

    public function getInfiniteCate()
    {
        $data = $this->getCateData();
        return $this->getInfiniteCateData($data);
    }

    /**
     * 递归获取无限极栏目数据
     * @param $cate
     * @param int $pid
     * @param int $level
     * @return array
     */
    private function getInfiniteCateData($cate, $pid = 0, $level=0)
    {
        static  $cateList = array();
        foreach ($cate as $key=>$value){
            if ($pid == $value['cate_pid']){
                $value['level'] = $level;
                $cateList[] = $value;
                $this->getInfiniteCateData($cate, $value['id'], $level+1);
            }
        }
        return $cateList;
    }

    /**
     * 判断当前栏目下是否存在子栏目 存在返回1 不存在返回0
     * @param $cateId
     * @return int
     */
    public function  getCateExistSonCate($cateId)
    {
        foreach ($this->getCateData() as $key=>$value){
            if ($value['cate_pid'] == $cateId){
               return 1;
            }
        }
        return 0;
    }

    /**
     * 获取当前栏目下所有的子栏目id合集
     * @param $id
     * @return array
     */

    public function getSonCateId($id)
    {
        static  $sonCate = array();
        foreach ($this->getCateData() as $key=>$value){
           if ($value['cate_pid'] == $id){
               $sonCate[] = $value['id'];
               $this->getSonCateId($value['id']);
           }
        }
        return $sonCate;
    }

}