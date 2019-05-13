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
use think\facade\Config;
use think\facade\Request;

class Rank extends BaseController
{
    protected $beforeActionList = [
        'auth'=>['only'=>'index'],
    ];
    public function index()
    {
        return view();
    }

    public function makeTask()
    {
        $data = Request::param();
        $web= $data['web'];
        $words = $data['words'];
        $wordsArr = explode('|', $words);
        $wordsStr = implode('-',$wordsArr);
        $enwords = urlencode($wordsStr);
        $token = Config::get('cms.chinazToken');
        $url = 'http://apidata.chinaz.com/BatchAPI/AllRanking';
        $postParam = [
            'key'=>$token,
            'domainName'=>$web,
            'keywords'=>$words,
        ];
        $postData = curl_post($url, $postParam);
        //halt($postData);
        $postArr = json_decode($postData);
        if ($postArr->StateCode == 1 && !empty($postArr->TaskID)){
            $this->redirect('admin/rank/task',['web'=>$web,'words'=>$enwords,'TaskID'=>$postArr->TaskID]);
        }else{
            die('创建失败！');
        }
    }

    public function task()
    {
        $data =Request::param();
        $words = explode('-', $data['words']);
        $words = implode('|',$words);
        $this->assign([
            'web'=>$data['web'],
            'TaskID'=>$data['TaskID'],
            'words'=>$words,
        ]);
        return view();
    }

    public function rankList()
    {
        $TaskID = Request::param('TaskID');
        $url = "http://apidata.chinaz.com/batchapi/GetApiData";
        $param = ['taskid'=>$TaskID];
        $postData = curl_post($url, $param);
        $postArr = json_decode($postData);
        if ($postArr->StateCode == 1){
            $reasonData = $postArr->Result->Data;
            foreach ($reasonData as$key=> $value){
                $reasonData[$key] = object_array($value);
            }
            $str = '<table class="layui-table">
        <thead>
        <tr>
            <th>搜索引擎</th>
            <th>关键字</th>
            <th>排名【页码-名次】</th>
            <th>标题</th>
            <th>链接</th>
            </tr>
        </thead>
        <tbody>';
            foreach ($reasonData as $key=>$value){
                foreach ($value as $k=>$v){
                    if (is_array($v['Result']['Ranks']) && count($v['Result']['Ranks'])>0){
                        foreach ($v['Result']['Ranks'] as $a=>$b){
                            $str.='<tr>';
                            $str .= '<td>'.$k.'</td>';
                            $str .= '<td>'.$v['Keyword'].'</td>';
                            $str .= '<td>'.$b['RankStr'].'</td>';
                            $str .= '<td>'.$b['Title'].'</td>';
                            $str .= '<td>'.$b['Url'].'</td>';
                            $str.='</tr>';
                        }
                    }
                }
            }
            $str.='</tbody></table>';
            // halt($str);
            return $str;
        }elseif($postArr->StateCode == 0){
            return json(['code'=>1, 'message'=>'数据暂未抓取完成，请稍等...']);
        }else{
            return json(['code'=>1, 'message'=>'未知错误！']);
        }


    }




}