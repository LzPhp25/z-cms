<?php
/**
 * Created by Lee_Phper.
 * User: Administrator
 * Date: 2019/4/22
 * Time: 13:44
 */

namespace app\admin\common\lib;


use think\Db;

class Map
{
    private $web; //网站地址
    private $leaf; //单页路由
    private $list; //列表路由
    private $article; // 内容路由
    private $time;//当前时间
    public function __construct($map)
    {
        $this->web =$map['agree'].$map['url'];
        $this->leaf = $map['page'];
        $this->list = $map['list'];
        $this->article = $map['article'];
        $this->time = date('Y-m-d');
    }

    public function makeMap()
    {
        return $this->createMap();
    }
    private function createMap()
    {
        $home = $this->makeHome();
        $cate = $this->makeCate($home);
        $list = $this->makeList($cate);
        $article = $this->makeArticle($list);
        $res = file_put_contents('sitemap.xml', $article);
        return $res;
    }

    private function makeHome()
    {
        $str ="<?xml version='1.0' encoding='UTF-8'?>\n";
        $str.= "<urlset  xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";
        $str.="<url>\n";
        $str.="<loc>".$this->web."</loc>\n";
        $str.="<lastmod>".$this->time."</lastmod>\n";
        $str.="<priority>1.0</priority>\n";
        $str.="</url>\n";
        return $str;
    }

    private function makeCate($str)
    {
        $cate = Db::name('cate')->where('cate_status',1)->where('temp_type',2)->field('id,create_time')->select();
        foreach ($cate as $key=>$value){
            $str.="<url>\n";
            $str.="<loc>".$this->web."/".$this->leaf."/".$value['id'].".html</loc>\n";
            $str.="<lastmod>".date('Y-m-d',$value['create_time'])."</lastmod>\n";
            $str.="<priority>0.8</priority>\n";
            $str.="</url>\n";
        }
        return $str;
    }
    private function makeList($str)
    {
        $cate = Db::name('cate')->where('cate_status',1)->where('temp_type',1)->field('id,create_time')->select();
        foreach ($cate as $key=>$value){
            $str.="<url>\n";
            $str.="<loc>".$this->web."/".$this->list."/".$value['id'].".html</loc>\n";
            $str.="<lastmod>".date('Y-m-d',$value['create_time'])."</lastmod>\n";
            $str.="<priority>0.8</priority>\n";
            $str.="</url>\n";
        }
        return $str;
    }
    private function makeArticle($str)
    {
        $article = Db::name('article')->where('reviewed',1)->field('id,create_time')->select();
        foreach ($article as $key=>$value){
            $str.="<url>\n";
            $str.="<loc>".$this->web."/".$this->article."/".$value['id'].".html</loc>\n";
            $str.="<lastmod>".date('Y-m-d',$value['create_time'])."</lastmod>\n";
            $str.="<priority>0.8</priority>\n";
            $str.="</url>\n";
        }
        $str.="</urlset>";
        return $str;
    }
}