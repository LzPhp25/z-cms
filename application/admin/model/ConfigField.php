<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/11
 * Time: 11:19
 */

namespace app\admin\model;
use app\admin\common\model\BaseModel;
class ConfigField extends BaseModel
{
    protected $table = 'lz_config_field';
    protected $pk = 'id';
    public $autoWriteTimestamp = true;
    protected $dateFormat = 'Y-m-d H:i:s';
}