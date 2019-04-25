<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 9:53
 */

namespace app\admin\common\model;
use app\admin\common\Exception\BaseException;
use app\admin\common\Exception\ReturnException;
use think\facade\Config;
use think\Model;
class BaseModel extends Model
{
    /**
     * 添加数据
     * @param $data
     * @param string $various
     * @return mixed
     * @throws BaseException
     * @throws ReturnException
     */
    public function addData($data, $various ='one')
    {
       if (!is_array($data)){
            throw new BaseException(['msg'=>'数据格式必须为数组！']);
       }
       if ($various == 'all'){
           $result = $this->allowField(true)->saveAll($data);
       }else{
           $result = $this->allowField(true)->save($data);
       }
       return $this->returnResult($result);
    }

    /**
     * 查询数据
     * @param $where
     * @param string $field
     * @return mixed
     * @throws ReturnException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function selectData($where, $field = '*')
    {
        $result = $this->where($where)->field($field)->select();
        return $this->returnResult($result);
    }

    /**
     * 修改数据
     * @param $data
     * @param string $various
     * @return mixed
     * @throws BaseException
     * @throws ReturnException
     */
    public function editData($data, $various ='one')
    {
        if (!is_array($data)){
            throw new BaseException(['msg'=>'数据格式必须为数组！']);
        }
        if ($various == 'all'){
            $result = $this->isUpdate(true)->allowField(true)->saveAll($data);
        }else{
            $result = $this->isUpdate(true)->allowField(true)->save($data);
        }
        return $this->returnResult($result);
    }

    /**
     * 删除数据
     * @param $param
     * @param bool $where
     * @return mixed
     * @throws ReturnException
     */
    public function delData($param, $where=false)
    {
       if ($where){
           $result = self::destroy(function ($query) use ($param){
               $query->where($param);
           });
       }else{
           $result = self::destroy($param);
       }
        return $this->returnResult($result);
    }

    /**
     * 定义返回结果
     * @param $result
     * @return mixed
     * @throws ReturnException
     */
    public function returnResult($result)
    {
        if ($result){
            return  $result;
        }else{
            throw new ReturnException();
        }
    }

    public function dataCount($where)
    {
        $data = $this->where($where)->count();
        return $data;
    }

    public function getPageData($where, $page, $size, $field='*')
    {
        $data = $this->where($where)->page($page, $size)->field($field)->select();
        return $data;
    }

    public function editStatus($id, $status)
    {
        $result = $this->isUpdate(true)->save(['id'=>$id,'status'=>$status]);
        return $result;
    }

}