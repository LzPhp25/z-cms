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

class Push extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];
    public function index()
    {
        $baiduToken = Db::name('system')->where('id',1)->value('baidu');
        $this->assign(
            [
                'baidu'=>$baiduToken,
            ]
        );
        return view();
    }

    public function pushUrl()
    {
        $data = Request::param();
        $urls = $data['urls'];
        $api = 'http://data.zz.baidu.com/urls?site='.$data['web'].'&token='.$data['token'];
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $resArr = json_decode($result);
        if (isset($resArr->error)){
            return backInfo(1, $resArr->message,[], 201);
        }
        if (isset($resArr->success)&& $resArr->success > 0){
            return backInfo(0, '提交成功！',[], 201);
        }
        if (isset($resArr->success) && $resArr->success == 0 && count($resArr->not_valid)>0){
            return backInfo(0, '存在不合法链接',[], 201);
        }

    }


}