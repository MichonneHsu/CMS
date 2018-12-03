<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/18
 * Time: 14:28
 */
class phone extends dataAdopter
{
    public function page_content($data){
        $html=$this->phone_header();
        $html.=$this->index_carousel();

        $html.=$this->container($data);
        $html.=$this->phone_footer();
        return $html;
    }
    public function index_carousel(){

        $html=$this->swiper($this->swiper_slide("<img src='".__HOME__."/img/cppimg.jpg'/>"),'carousel');
        return $html;
    }
    public function phone_header(){
        $html="<nav class='navbar navbar-default navbar-fixed-top'>";
        $html.="<div class='container-fluid'>";
        $html.="<div class='navbar-header'>";
        $html.=" <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#oule-collapse' aria-expanded='false'>";
        $html.="<span class='icon-bar'></span>";
        $html.="<span class='icon-bar'></span>";
        $html.="<span class='icon-bar'></span>";
        $html.="</button>";#button
        $html.="<a class='oule-brand' href='http://www.dezhououle.cn/m.html'><img src='".__HOME__."/img/logo.png'/></a>";
        $html.="</div>";#navbar-header
        $html.="<div class='collapse navbar-collapse ' id='oule-collapse'>";
        $html.="<ul class='nav navbar-nav'>";
        $html.="<li><a href='m.html'>首页<span class='sr-only'>(current)</span></a></li>";
        $html.="<li><a href='m-about.html'>关于欧乐</a></li>";
        $html.="<li><a href='m-contact.html'>联系我们</a></li>";
        $html.="</ul>";
        $html.="</div>";
        $html.="</div>";#container-fluid
        $html.="</nav>";#navbar
        return $html;
    }
    public function phone_footer(){
        $tel=$this->getdata('zr_rights','tel');
        $html="<div class='btn-group btn-group-justified oule-bottom'>";
        $html.="<div class='btn btn-default'><a class='btn-oule' href='m.html' role='button'>首页</a></div>";
        $html.="<div class='btn btn-default'><a class='btn-oule' href='m-about.html' role='button'>关于欧乐</a></div>";
        $html.="<div class='btn btn-default'><a class='btn-oule' href='m-contact.html' role='button'>联系我们</a></div>";
        $html.="<div class='btn btn-default'><a class='btn-oule' href='tel:{$tel['tel']}' role='button'>点击拨打</a></div>";
        $html.="</div>";

//        $html="<div class='btn-group btn-group-justified oule-bottom'>";
//        $html.="<div class='btn btn-default'><a class='btn-oule' href='m-about.html' role='button'>关于我们</a></div>";
//        $html.="<div class='btn btn-default'><a class='btn-oule' href='' role='button'>电话咨询</a></div>";
//        $html.="<div class='btn btn-default'><a class='btn-oule' href='tel:{$tel['tel']}' role='button'>在线客服</a></div>";
//        $html.="<div class='btn btn-default'><a class='btn-oule' href='' role='button'>产品中心</a></div>";
//        $html.="</div>";
        return $html;
    }
}