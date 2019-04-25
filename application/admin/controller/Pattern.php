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
use app\admin\validate\CustomValidate;
use app\admin\validate\PatternValidate;
use think\Db;
use think\facade\Config;
use think\facade\Request;
use \app\admin\model\Pattern as PatternModel;
class Pattern extends BaseController
{

    protected $beforeActionList = [
        'auth'=>['index'],
    ];
    public function index()
    {
        $parttern = model('pattern')->selectData([]);
        $this->assign(['pattern'=>$parttern]);
        return view();
    }
    public function add()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            $table = $data['table_name'];
            (new PatternValidate())->checkData($data);
            $tableName = $this->prefix.$table;
            $exit = $this->exitTable($tableName);
            if ($exit == 1){
                return backInfo(3, '该表已存在！',[], 201);
            }

            $saveData = ['name'=>$data['name'], 'table_name'=>$table,'add_table'=>$table.'_field','status'=>1,'create_time'=>time()];
            $res = model('pattern')->allowField(true)->save($saveData);
            if ($res){
                return backInfo(0, '添加成功！',[], 201);
            }
        }
        return view();
    }
    public function edit()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            if(!isset($data['status'])){
                $data['status'] = 0;
            }
            (new PatternValidate())->checkData($data);
            $table = $data['table_name'];
            $saveData = ['id'=>$data['id'],'name'=>$data['name'], 'table_name'=>$table,'add_table'=>$table.'_field','status'=>$data['status'],'create_time'=>time()];
            $res = model('pattern')->allowField(true)->isUpdate(true)->save($saveData);
            if ($res){
                return backInfo(0, '编辑成功！',[], 201);
            }
        }
        $id = Request::param('id');
        $pattern =model('pattern')->find($id);
        $this->assign([
            'pattern'=> $pattern,
        ]);
        return view();
    }
    public function delete()
    {
        $id = Request::param('id');
        $res = PatternModel::destroy($id);
        if ($res){
            return backInfo(0, '删除成功！',[], 201);
        }else{
            return backInfo(1, '删除失败！',[], 201);
        }
    }
    public function exitTable($tableName)
    {
        $exitSql = "SELECT table_name FROM information_schema.TABLES WHERE table_name ='$tableName';";
        $result = Db::execute($exitSql);
        return $result;
    }
    public function field()
    {
        $id = Request::param('id');
        $fieldTableName = PatternModel::getAddFieldTableName($id);
        $tableName = PatternModel::getAddTableName($id);
        $field = Db::name($fieldTableName)->select();
        $this->assign([
            'field'=> $field,
            'table'=>$tableName
        ]);
        return view();
    }
    public function addField()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            (new CustomValidate())->checkData($data);
            $insertData = [
                 'cn_name'=>$data['cn_name'],
                 'en_name'=>$data['en_name'],
                 'value'=>$data['value'],
                 'values'=>$data['values'],
                 'length'=>$data['length'],
                 'field_type'=>$data['field_type'],
                 'create_time'=>time(),
            ];
            $res = Db::name($data['table'].'_field')->insert($insertData);
            if ($res){
                $this->addSqlField($data);
                return backInfo(0, '添加成功！',[], 201);
            }else{
                return backInfo(1, '添加失败！',[], 201);
            }

        }
        $table = Request::param('table');
        $this->assign([
            'table'=>$table,
        ]);
        return view();
    }
    public function addSqlField($data)
    {
        $table = $this->prefix.$data['table'];
        $filed = $data['en_name'];
        $length = $data['length'];
        if ($data['length'] > 255){
            $sql =  " alter table $table add $filed TEXT;";
        }else{
            $sql = " alter table $table add $filed varchar($length) default null ;";
        }
        Db::execute($sql);
    }
    public function editField()
    {
        if (Request::isAjax(true)){
            $data = Request::param();
            (new CustomValidate())->checkData($data);
            $editData = [
                'cn_name'=>$data['cn_name'],
                'en_name'=>$data['en_name'],
                'value'=>$data['value'],
                'values'=>$data['values'],
                'length'=>$data['length'],
                'field_type'=>$data['field_type'],
                'create_time'=>time(),
            ];
            $res = Db::name($data['table'].'_field')->where('id', $data['id'])->update($editData);
            if ($res){
                $this->editSqlField($data);
                return backInfo(0, '编辑成功！',[], 201);
            }else{
                return backInfo(1, '编辑失败！',[], 201);
            }

        }
        $table = Request::param('table');
        $id = Request::param('id');
        $field =  Db::name($table.'_field')->where('id', $id)->find();
        $this->assign([
            'table'=>$table,
            'field'=>$field,
        ]);
        return view();
    }
    public function editSqlField($data)
    {
        if ($data['old_en_name']!=$data['en_name'] || $data['old_length']!=$data['length'] ){
            $table = $this->prefix.$data['table'];
            $filed = $data['en_name'];
            $length = $data['length'];
            if ($length > 255){
                if ($data['old_en_name'] != $data['en_name']){
                    $oldField = $data['old_en_name'];
                    $sql = "ALTER TABLE $table CHANGE $oldField $filed TEXT;";
                }else{
                    $sql = "alter table $table modify column $filed TEXT;";
                }
                Db::execute($sql);
            }else{
                if ($data['old_en_name'] != $data['en_name']){
                    $oldField = $data['old_en_name'];
                    $sql = "ALTER TABLE $table CHANGE $oldField $filed VARCHAR($length);";
                }else{
                    $sql = "alter table $table modify column $filed varchar($length);";
                }
                Db::execute($sql);
            }
        }

    }
    public function delField()
    {
       $data = Request::param();
       $table = $data['table'];
       $id =  $data['id'];
        if (is_array($id)){
            foreach ($id as $value){
                $this->delFieldTableData($table, $value);
            }
        }else{
            $this->delFieldTableData($table, $id);
        }
        return backInfo(0, '删除成功！',[], 201);
    }
    public function delSqlField($table, $field)
    {
        $sql = "alter table $table drop column $field";
        Db::execute($sql);
    }
    public function delFieldTableData($table, $id)
    {
        $fieldName = $this->getFieldValue($table.'_field', $id);
        Db::name($table.'_field')->where('id', $id)->delete();
        $this->delSqlField($this->prefix.$table, $fieldName);
    }
    public function getFieldValue($table, $id)
    {
       $data =  Db::name($table)->where('id', $id)->value('en_name');
       return $data;
    }
    public function changeSelected()
    {
        if (Request::isAjax(true)){
            $id = Request::param('id');
            $res = Db::name('pattern')->where('id', $id)->update(['selected'=>1]);
            $ret =   Db::name('pattern')->where('id','<>',$id)->update(['selected'=>0]);
            if ($res && $ret){
                return backInfo(0, '修改成功！',[], 200);
            }
        }
    }

}