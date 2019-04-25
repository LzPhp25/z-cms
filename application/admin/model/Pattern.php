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
use think\facade\Config;
use think\facade\Request;

class Pattern extends BaseModel
{
    protected $table = 'lz_pattern';
    protected $pk = 'id';
    public static function init()
    {
        $prefix = Config::get('database.prefix');
        self::event('after_insert', function ($data) use ($prefix){
            $tableName =  $prefix.$data['table_name'];
            $tableField = $prefix.$data['add_table'];
            Db::execute("CREATE TABLE `$tableName` (`art_id` mediumint(9) DEFAULT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
            $createTableFieldSql = "CREATE TABLE `$tableField` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `en_name` varchar(20) DEFAULT NULL,
  `cn_name` varchar(20) DEFAULT NULL,
  `value` text,
  `values` text,
  `length` smallint(6) DEFAULT NULL,
  `sort` mediumint(6) DEFAULT '12',
  `create_time` int(10) DEFAULT NULL,
  `field_type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
            Db::execute($createTableFieldSql);
        });
        self::event('after_update', function ($pattern)  use ($prefix){
            $data = Request::param();
            if ($data['table_name'] != $data['old_table']){
                $oldTable = $prefix.$data['old_table'];
                $oldFieldTable = $prefix.$data['old_table'].'_field';
                $tableName =  $prefix.$data['table_name'];
                $tableField = $prefix.$data['table_name'].'_field';
                Db::execute("ALTER TABLE  $oldTable RENAME TO  $tableName;");
                Db::execute("ALTER TABLE  $oldFieldTable  RENAME TO  $tableField;");
            }
        });
        self::event('after_delete', function ($pattern) use ($prefix){
            $table = $prefix.$pattern['table_name'];
            $fieldTable = $prefix.$pattern['add_table'];
            Db::execute("DROP TABLE $table ;");
            Db::execute("DROP TABLE $fieldTable ;");
        });


    }
    public static function getAddTableName($id)
    {
        $name = self::where('id', $id)->value('table_name');
        return $name;
    }

    public static function getAddFieldTableName($id)
    {
        $name = self::where('id', $id)->value('add_table');
        return $name;
    }

}