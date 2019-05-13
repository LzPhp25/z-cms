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
use app\admin\common\lib\Map;
use \app\admin\model\ConfigField as ConfigFieldModel;
use think\Db;
use think\facade\Request;

class SiteMap extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];
    public function index()
    {
        return view();
    }

    public function makeMap()
    {
        $data = Request::param();
        $map = new Map($data);
        $res = $map->makeMap();
        if ($res){
            return backInfo(0, '创建地图成功！',[], 201);
        }
    }

}