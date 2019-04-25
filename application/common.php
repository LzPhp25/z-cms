<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * @param int $code
 * @param string $message
 * @param array $data
 * @param $httpCode
 * @return \think\response\Json
 */
function backInfo($code=0, $message='', $data=[], $httpCode)
{
    $result = array(
        'code'=>$code,
        'message'=>$message,
        'data'=>$data,
    );
    return json($result, $httpCode);
}

/**
 * 返回layui动态分页格式
 * @param int $code
 * @param string $message
 * @param int $count
 * @param array $data
 * @param int $httpCode
 * @return \think\response\Json
 */
function backPageInfo($code=0, $message='', $count =0 ,$data=[], $httpCode=201)
{
    $result = array(
        'code'=>$code,
        'msg'=>$message,
        'count'=>$count,
        'data'=>$data,
    );
    return json($result, $httpCode);
}

/**post请求
 * @param string $url
 * @param string $param
 * @return bool|string
 */
function curl_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }
    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init();//初始化curl
    curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch);//运行curl
    curl_close($ch);

    return $data;
}

/**
 * get请求
 * @param $durl
 * @return bool|string
 */
function curl_get($durl)
{
    $curl = curl_init(); // 初始化
    curl_setopt($curl, CURLOPT_URL, $durl);    // 设置url路径
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) ;
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true) ;
    curl_setopt($curl, CURLOPT_HTTPHEADER, 0);
    curl_setopt($curl, CURLINFO_HEADER_OUT, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($curl); // 执行
    curl_close($curl);// 关闭连接
    return $data;  // 返回数据
}

/**
 * 对象转数组
 * @param $array
 * @return array
 */
function object_array($array) {
    if(is_object($array)) {
        $array = (array)$array;
    } if(is_array($array)) {
    foreach($array as $key=>$value) {
        $array[$key] = object_array($value);
    }
}
     return $array;
}

/**获取文件夹列表
 * @param $dir
 * @return array
 */
function getDir($dir) {
    $dirArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while ( false !== ($file = readdir ( $handle )) ) {
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".."&&!strpos($file,".")) {
                $dirArray[$i]=$file;
                $i++;
            }
        }
        //关闭句柄
        closedir ( $handle );
    }
    return $dirArray;
}


function scanFile($path) {
    global $result;
    $files = scandir($path);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            if (is_dir($path . '/' . $file)) {
                scanFile($path . '/' . $file);
            } else {
                $result[] = basename($file);
            }
        }
    }
    return $result;
}




