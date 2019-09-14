<?php

include_once 'database.class.php';
/***
 * SimplePhp
 * By Michonne
 * oh my god
 */
class dataAdopter extends database {
    /**
     * @param string $table
     * @param string $column
     * @param string $where
     * @return array
     */
    public function getdata($table,$column='',$where=''){
        $divided_data=explode(',',$column);
        $columnData=implode(',',$divided_data);
        if($where=='' || $where==null || empty($where) || !isset($where)){
            $where='';
        }else{
            $where=" where ".$where;
        }
        $sql="select ".$columnData." from ".$table.$where." limit 1";

        $res=$this->data($sql);

        return $res;
    }
    public function hasData($table,$column='',$where=''){
        $divided_data=explode(',',$column);
        $columnData=implode(',',$divided_data);
        if($where=='' || $where==null || empty($where) || !isset($where)){
            $where='';
        }else{
            $where=" where ".$where;
        }
        $sql="select ".$columnData." from ".$table.$where." limit 1";

       $res=$this->findData($sql);

       if($res<0){
           return 0;
       }else{
           return 1;
       }
    }

    /**
     * @param string $table
     * @param string $column
     * @param string $where
     * @param string $limit
     * @return array
     */
    public function select($table,$column,$where='',$limit='',$order=''){

        if($where=='' || $where==null || empty($where) || !isset($where)){
            $where='';
        }else{
            $where=" where ".$where;
        }
        if($order=='' || $order==null || empty($order) || !isset($order)){
            $order='';
        }else{
            $order=" order by ".$order;
        }
        if($limit=='' || $limit==null || empty($limit) || !isset($limit)){
            $limit='';
        }else{
            $limit=" limit ".$limit;
        }
        $sql="select ".$column." from ".$table.$where.$order.$limit;

        $arr=$this->getAssoc($sql);

        return $arr;

    }
    public function oule_seo($title,$description,$keywords){

        $html="<title>{$title}</title>";
        $html.="<meta name='description' content='{$description}'>";
        $html.="<meta name='keywords' content='{$keywords}'>";

        return $html;
    }
    public function seo(){
        $seo=$this->seo_data();
        $html="<title>{$seo['seo_default_title']}</title>";
        $html.="<meta name='description' content='{$seo['seo_descriptions']}'>";
        $html.="<meta name='keywords' content='{$seo['seo_keywords']}'>";

        return $html;
    }
    public function seo_data(){
        return $this->getdata('zr_seo','*');
    }
    /**
     * @param $data
     * @return string
     */
    public function htmlEncode($data){
        return htmlspecialchars($data);
    }

    /**
     * @param array $arr
     * @return string
     */
    public function stringify($arr=array()){
       return implode(',',$arr);
    }

    /**
     * @param array $column
     * @return string
     */
    public function getcolumn($column=array()){
        $k=array_keys($column);
        return $this->stringify($k);
    }

    /**
     * @param array $values
     * @return string
     */
    public function getvalues($values=array()){
        $v=array_values($values);
        return  $this->stringify($v);
    }

    /**
     * @param array $keys
     * @return array
     */
    public function array_key($keys=array()){
        return array_keys($keys);
    }

    /**
     * @param array $values
     * @return array
     */
    public function array_value($values=array()){
      return array_values($values);

    }

    /**
     * @param $table
     * @param $data
     * @return int
     */
    public function add($table,$data){
        $k=$this->array_key($data);
        $v=$this->array_value($data);
        $value=array();
        for($i=0;$i<count($k);$i++){
            $value[$i]='"'.$v[$i].'"';#拼接值 "1","2" ~
        }
        $values=$this->getvalues($value);
        $columns=$this->getcolumn($data);
        $query=$this->query('insert into '.$table.' ('.$columns.')values('.$values.')');

        if($this->affected_rows()<=0){

            return 0;
        }else{

            return 1;
        }


    }

    /**
     * @param $table
     * @param $where
     * @return int
     */
    public function delete($table,$where){
        $query=$this->query('delete from '.$table.' where '.$where);
        $this->free($query);
        if($this->affected_rows()<0){

            return 0;

        }else{
            return 1;
        }

    }

    /**
     * @param string $table
     * @param string $column
     * @param string $where
     * @return int
     */
    public function update($table,$data,$where=''){
        $c=$this->array_key($data);
        $v=$this->array_value($data);
        $colomn=array();
        $colomns='';
        for($i=0;$i<count($c);$i++){
            $colomn[$i]=$c[$i].'='.'"'.$v[$i].'"';#将键名和值用等于号拼接 a="c" 格式;
        }

        $colomns=$this->getvalues($colomn);

        if($where=='' || $where==null || empty($where) || !isset($where)){
            $where='';
        }else{
            $where=" where ".$where;
        }
        $query=$this->query('update '.$table.' set '. $colomns.$where);
        $this->free($query);
        if($this->affected_rows()<0){
            return 0;
        }else{
            return 1;
        }
    }
    /**
     * @return upload
     */
    public function upload(){
        $upload= new upload();
        return $upload;
    }

    /**
     * @return page
     */
    public function page(){
        $page = new page();
        return $page;
    }
    public function return_button(){
        return '<span class="return_button" onclick="history.back();">返回</span>';
    }
    public function html_header(){
        $rights=$this->rights();
        $seo=$this->seo_data();
        $logo="<img class='logo-img' src='".__HOME__."/img/logo.png' alt='{$seo['seo_default_title']}'/>";
        $header_text_one="<p><span class='green'>16年</span>专注<span class='green'>土工膜</span>研发生产销售</p>";
//        $header_text_one.="<p>客户没想到的我们要做到</p>";
//        $header_text_one.="<p>客户想到的我们要做好</p>";
        $header_text_two="<p>全国咨询热线：{$rights['tel']}</p>";
        $header_text_two.="<p>投诉电话：{$rights['complain_numbers']}</p>";
        $header_text_three="<div class='head-contact'><p><a href='sitemap.html' class='site-map '>站点地图</a></p>";
        $header_text_three.="<p><a href='contact.html' class='contact-text'>联系欧乐</a></p></div>";
        $list=$this->div('col-xs-12 col-md-3 col-lg-4',$logo);#logo
        $list.=$this->div('col-xs-12 col-md-3 col-lg-3',$header_text_one);
        $list.=$this->div('col-xs-12 col-md-3 col-lg-3',$header_text_two);
        $list.=$this->div('col-xs-12 col-md-3 col-lg-2',$header_text_three);
        $text="<p>您好，欢迎来到德州欧乐官网！</p>";
        $html="<div class='welcome_text'>";
        $html.=$this->container($text);
        $html.="</div>";
        $html.=$this->container($this->row($list),'header-content');
        $html.=$this->navs();
        return $html;
    }

    public function navs(){
//        $html="<nav class='navbar navbar-default'>";
//        $html.="<div class='navbar-header'>";
//        $html.="<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1' aria-expanded='false'>";
//        $html.="<span class='sr-only'>Toggle navigation</span>";
//        $html.="<span class='icon-bar'></span>";
//        $html.="<span class='icon-bar'></span>";
//        $html.="<span class='icon-bar'></span>";
//        $html.="</button>";
//        $html.="</div>";#navbar-header
//        $html.="<div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>";
//        $html.="<ul class='nav navbar-nav'>";
//        $html.="<li><a href=''>欧乐首页</a></li>";
//        $html.="<li><a href=''>垃圾填埋场</a></li>";
//        $html.="<li><a href=''>尾矿库</a></li>";
//        $html.="<li><a href=''>人工湖|河道</a></li>";
//        $html.="<li><a href=''>水产养殖</a></li>";
//        $html.="<li><a href=''>公路铁路</a></li>";
//        $html.="<li><a href=''>园林绿化</a></li>";
//        $html.="<li><a href=''>工程案例</a></li>";
//        $html.="<li><a href=''>新闻动态</a></li>";
//        $html.="<li><a href=''>关于欧乐</a></li>";
//        $html.="</ul>";
//        $html.="</div>";
//        $html.="</nav>";
        $html="<ul class='nav nav-pills nav-justified'>";
        $html.="<li><a href='index.html'>欧乐首页</a></li>";
       foreach($this->select('zr_ca','ca_id,ca_name') as $k=>$v){
           $html.="<li><a href='main-{$v['ca_id']}.html'>{$v['ca_name']}</a></li>";
       }
        $html.="<li><a href='engpage.html'>工程案例</a></li>";
        $html.="<li><a href='news.html'>新闻动态</a></li>";
        $html.="<li><a href='about.html'>关于欧乐</a></li>";
        $html.="</ul>";
        $navs="<div class='navs'>".$this->container($html)."</div>";
        return $navs;
    }

    public function aboutcate(){
        $html="<div class='col-xs-4'>";
        $html.="<ul class='list-group about-cates'>";
        $html.="<li class='list-group-item'><a href='about.html'>公司介绍</a></li>";
        $html.="<li class='list-group-item'><a href='org.html'>组织架构</a></li>";
        $html.="<li class='list-group-item'><a href='cp.html'>企业文化</a></li>";
        $html.="</ul>";
        $html.="</div>";
        return $html;
    }
    public function newsSideCate(){

        $html="<div class='col-xs-4'>";
        $html.="<div class='category-section '>";
        $html.="<h3 class='default-theme-color'>新闻资讯</h3>";
        $html.="<ul class='categoru-ul'>";
        foreach($this->select('zr_newscate','newscate_id,newscate_name') as $k=>$v){
            $html.="<li><a href='news-{$v['newscate_id']}.html'>{$v['newscate_name']}</a></li>";
        }
        $html.="<li><a href='customer.html'></span>客户留言</a></li>";

        $html.="</ul>";
        $html.="<h3 class='default-theme-color'>实力展示</h3>";
        $html.="<ul class='categoru-ul'>";
        $html.="<li><a href='qh.html'></span>检测证书</a></li>";
        $html.="<li><a href='ps.html'></span>生产设备</a></li>";
        $html.="<li><a href='pd.html'></span>生产原料</a></li>";
        $html.="</ul>";
        $html.="</div>";
        $html.="</div>";
        return $html;
    }
    public function back(){
        return '<h5><a href="#" onclick="history.back();">返回</a></h5>';
    }
    public function keywords(){
        $html="<ul class='col-xs-9 col-md-9'>";
        $html.="<li><span>热门关键词：</span></li>";
        foreach($this->select('zr_product','product_id,product_pid,product_name','hw=1',4,'') as $k=>$v){
            $html.="<li><a href='productpage-{$v['product_id']}-{$v['product_pid']}.html'>{$v['product_name']}</a></li>";
        }


        $html.="</ul>";
        $html.="<div class='search col-xs-3 col-md-3'>";
        $html.="<form class='pull-right' action='search.html' method='post'>";
        $html.="<input type='text' name='search_bar'>";
        $html.="<button type='submit'>搜索</button>";
        $html.="</form>";
        $html.="</div>";
        return "<div class='keywords'>".$this->container($this->row($html))."</div>";
    }
    public function bottom_info(){
        $rights=$this->rights();
        $html="<div class='bottom'>";
        $html.="<div class='col-md-2'><div class='sublogo'><img src='".__HOME__."/img/sublogo.png'/></div></div>";
        $html.="<div class='col-md-4'>";
        $html.="<div class='bottom_info'>";
        $html.="<p>{$rights['company']}</p>";
        $html.="<p>地址：{$rights['company_addr']}</p>";
        $html.="<p>资讯热线：{$rights['tel']}</p>";
        $html.="<p>投诉电话：{$rights['complain_numbers']}</p>";
        $html.="<p>电子邮箱：{$rights['email']}</p>";
        $html.="<p>备案号：<a href='http://www.miitbeian.gov.cn'>{$rights['reserved_number']}</a></p>";
        $html.="</div>";#bottom_info
        $html.="</div>";
        $html.="<div class='clearfix'></div></div>";
        return $this->container($this->row($html));
    }
    public function carousel(){
        $list1="<div class='banner'>";
        $list1.="<img src='".__HOME__."/img/b1.jpg'/>";
        $list1.="</div>";
        $list2="<div class='banner'>";
        $list2.="<img src='".__HOME__."/img/b2.jpg'/>";
        $list2.="</div>";
        $list3="<div class='banner'>";
        $list3.="<img src='".__HOME__."/img/b3.jpg'/>";
        $list3.="</div>";
        $html=$this->swiper_slide($list1);
        $html.=$this->swiper_slide($list2);
        $html.=$this->swiper_slide($list3);
        $controller="<div class='swiper-pagination eng-pagination'></div>";
        return $this->swiper($html,'carousel',$controller);
    }
    public function rights(){
        return $this->getdata('zr_rights',"*");
    }
    public function after_sell(){

        $html=$this->content_title('售后服务');

        $html.="<div class='col-xs-6'>";
        $html.="<div class='media'>";
        $html.="<div class='media-left'>";
        $html.="<img class='media-object' src='".__HOME__."/img/s1.png'/>";
        $html.="</div>";#media-left
        $html.="<div class='media-body'>";
        $html.="<p><h4><span class='green'>免费</span>施工方案指导</h4></p>";
        $html.="<p>类似项目施工方案免费送</p>";
        $html.="</div>";
        $html.="</div>";#media
        $html.="</div>";#col

        $html.="<div class='col-xs-6'>";
        $html.="<div class='media'>";
        $html.="<div class='media-left'>";
        $html.="<img class='media-object' src='".__HOME__."/img/s4.png'/>";
        $html.="</div>";#media-left
        $html.="<div class='media-body'>";
        $html.="<p><h4><span class='green'>免费</span>咨询行业技术</h4></p>";
        $html.="<p>我们不怕“教会徒弟，饿死师傅”</p>";
        $html.="<p>因为“你好，我也好”</p>";
        $html.="</div>";
        $html.="</div>";#media
        $html.="</div>";#col

        $html.="<div class='col-xs-6'>";
        $html.="<div class='media'>";
        $html.="<div class='media-left'>";
        $html.="<img class='media-object' src='".__HOME__."/img/s3.png'/>";
        $html.="</div>";#media-left
        $html.="<div class='media-body'>";
        $html.="<p><h4>全球“<span class='green'>上门</span>焊接安装”</h4></p>";
        $html.="<p>只有您的项目到不了的地方</p>";
        $html.="<p>没有我们技术工人到不了的地方</p>";
        $html.="</div>";
        $html.="</div>";#media
        $html.="</div>";#col

        $html.="<div class='col-xs-6'>";
        $html.="<div class='media'>";
        $html.="<div class='media-left'>";
        $html.="<img class='media-object' src='".__HOME__."/img/s2.png'/>";
        $html.="</div>";#media-left
        $html.="<div class='media-body'>";
        $html.="<p><h4><span class='green'>正规发票</span></h4></p>";
        $html.="<p>手续齐全，放心购买</p>";
        $html.="</div>";
        $html.="</div>";#media
        $html.="</div>";#col
        $container="<div class='after_sell'>";
        $container.=$this->container($html);

        $container.="</div>";
        return $container;
    }
    public function reasons(){
        $reason_one="<div class='reason-one'>";#reason-one
        $reason_one_html="<div class='col-xs-6'>";
        $reason_one_html.="<ul class='reason-ul'>";
        $reason_one_html.="<li><h4><span class='numbers'>01</span>不掺<span class='green'>1粒</span>回收料，不走<span class='green'>负</span>偏差</h4></li>";
        $reason_one_html.="<ul>";
        $reason_one_html.="<li><p>&nbsp;进口<span class='green'>专用</span>原包料，拒绝以次充好，以假乱真</p></li>";
        $reason_one_html.="<li><p>&nbsp;严格按照产品标准要求生产，<span class='green'>不偷</span>工减料</p></li>";
        $reason_one_html.="</ul>";
        $reason_one_html.="</ul>";
        $reason_one_html.="<ul class='reason-ul'>";
        $reason_one_html.="<li><h4><span class='numbers'>02</span>满足国外客户<span class='green'>定制</span>高标准产品，很多同行做不到</h4></li>";
        $reason_one_html.="<ul>";
        $reason_one_html.="<li><p>&nbsp;客户提要求，我们来满足，专业设备，专业团队</p></li>";
        $reason_one_html.="</ul>";
        $reason_one_html.="</ul>";
        $reason_one_html.="</div>";#col-xs-6
        $reason_one_html.="<div class='col-xs-6'>";
        $reason_one_html.="<img src='".__HOME__."/img/bb.jpg'>";
        $reason_one_html.="</div>";
        $reason_one.=$this->container($this->row($reason_one_html));
        $reason_one.="</div>";#reason-one
        $reason_two="<div class='reason-two background'>";
        $reason_two_html="<div class='col-xs-6'><img src='".__HOME__."/img/cars.jpg'/></div>";
        $reason_two_html.="<ul class='col-xs-6 reason-ul'>";
        $reason_two_html.="<li><h4><span class='numbers'>03</span>生产、销售、施工&nbsp;<span class='green'>16年</span>行业经验，<span class='green'>50年</span>不漏</h4></li>";
        $reason_two_html.="<li><h4><span class='numbers'>04</span>售前.售中.售后&nbsp;<span class='green'>2小时</span>快速响应，24小时内解决</h4></li>";
        $reason_two_html.="<li><h4><span class='numbers'>05</span>近5年来<span class='green'>0</span>质量投诉</h4></li>";
        $reason_two_html.="<li><h4><span class='numbers'>06</span>全国发货<span class='green'>3</span>至<span class='green'>5</span>天</h4></li>";
        $reason_two_html.="</ul>";
        $reason_two.=$this->container($this->row($reason_two_html));
        $reason_two.="</div>";#reason-two

        $reason_three="<div class='reason-three'>";
        $reason_three_html="<ul class='col-xs-6 reason-ul'>";
        $reason_three_html.="<li><h4><span class='numbers'>07</span>众多名企的长期合作供应商</h4></li>";
        $reason_three_html.="<li><h4><span class='numbers'>08</span>除非老板不干了，全年<span class='green'>365天</span>不打烊<span class='green'>！</span></h4></li>";
        $reason_three_html.="</ul>";
        $reason_three_html.="<div class='col-xs-6'><img src='".__HOME__."/img/ry_bg.jpg'/></div>";
        $reason_three.=$this->container($this->row($reason_three_html));
        $reason_three.="</div>";#reason-three

        return "<div class='reasons content-padding'>".$this->content_title('选择欧乐<span>8</span>大理由').$reason_one.$reason_two.$reason_three."</div>";
    }
    public function partners(){


        $imgs="<div class='col-xs-6 col-md-6'>";
        $imgs.="<div class='partners-img'><img src='".__HOME__."/img/c1.png' alt=''></div>";
        $imgs.="</div>";
        $imgs.="<div class='col-xs-6 col-md-6'>";
        $imgs.="<div class='partners-img'><img src='".__HOME__."/img/c2.png' alt=''></div>";
        $imgs.="</div>";

        $html="<div class='partners make-space'>";
        $html.=$this->content_title('合作伙伴');
        $html.=$this->container($this->row($imgs));
        $html.="</div>";
        return $html;
    }
    public function content_title($title,$url=''){
        if($url==''){
            $url="#";
        }
        $html="<div class='content-title'><h2><a href='{$url}'>{$title}</a></h2></div>";
        return $html;
    }
    public function jumbotron(){
        $html="<div class='jumbotron cpimg'>";
        $html.="</div>";
        return $this->container($this->row($html));
    }
    public function swiper_slide($html){
        return "<div class='swiper-slide'>{$html}</div>";
    }
    public function swiper($html,$classname='',$controller='',$otherhtml=''){
        $swiper=$otherhtml;
        $swiper.="<div class='swiper-container {$classname}'>";
        $swiper.="<div class='swiper-wrapper'>{$html}</div>";
        $swiper.="{$controller}";
        $swiper.="</div>";
        return $swiper;
    }

    public function div($class_name,$html){
        return "<div class='{$class_name}'>{$html}</div>";
    }
    public function container($html,$classname=''){
        return "<div class='container {$classname}'>{$html}</div>";
    }

    public function row($html,$classname='',$others=''){
        return "{$others}<div class='row {$classname}'>{$html}</div>";
    }
    public function htmlDecode($data){
        return htmlspecialchars_decode($data);
    }
    public function rectify($data){
        $o="最、最佳、最具、最爱、最赚、最优、最优秀、最好、最大、最大程度、最高、最高级、最高端、
        最奢侈、最低、最低级、最低价、最底、最便宜、史上最低价、最流行、最受欢迎、最时尚、最聚拢、
        最符合、最舒适、最先、最先进、最先进科学、最后、最新、最新技术、最新科学、先进第一、中国第一、
        全网第一、销量第一、排名第一、唯一、第一品牌、NO.1、TOP1、独一无二、全国第一、遗留、一天、仅此一次、一款、最后一波、全国大品牌之一、销冠、全国、
        国家级、国际级、世界级、千万级、百万级、星级、5A、甲级、超甲级、
        顶级、顶尖、尖端、顶级享受、高级、极品、极佳、绝佳、绝对、终极、极致、致极、极具、完美、绝佳、至、至尊、至臻、臻品、
        臻致、臻席、压轴、问鼎、空前、绝后、绝版、无双、非此莫属、巅峰、前所未有、无人能及、
        鼎级、鼎冠、定鼎、完美、翘楚之作、不可再生、不可复制、绝无仅有、寸土寸金、淋漓尽致、无与伦比、唯一、卓越、卓著、再生、
        前无古人后无来者、绝版、珍稀、臻稀、稀少、绝无仅有、绝不在有、稀世珍宝、千金难求、世所罕见、不可多得、空前绝后、寥寥无几、屈指可数、
        首个、首选、独家、首发、首席、首府、首选、首屈一指、全国首家、国家领导人、国门、国宅、首次、填补国内空白、国际品质、
        黄金旺铺、黄金价值、黄金地段、金钱、金融汇币图片、外国货币、
        大牌、金牌、名牌、王牌、领先上市、巨星、著名、掌门人、至尊、冠军、王、之王、王者楼王、墅王、皇家、
        世界领先、遥遥、领先、领导者、领袖、引领、创领、领航、耀领、
        史无前例、前无古人、万能、百分之百、
        特供、专供、专家推荐、国家习近平领导人推荐、使用人民币图样、
        售罄、售空、再不抢就没了、史上最低价、不会再便宜、没有他就、错过不再、错过即无、错过就没机会了、未曾有过的、万人疯抢、
        全民疯抢、抢购、免费领、免费住、0首付、免首付、零距离、价格你来定、
        学校名称、升学、教育护航、九年制教育、一站式教育、入住学区房、优先入学、12年教育无忧、全程无忧、让孩子赢在起跑线上、
        承诺户口、蓝印户口、承诺移民、买个房啥都解决了、
        上风上水、聚财纳气、宝地、圣地、府邸、龙脉、贵脉、东西方神话人物、龙脉之地、风水宝地、天人合一、天干地支品上山上水、享上等上城、堪舆、
        帝都、皇城、皇室领地、皇家、皇室、皇族、殿堂、白宫、王府、府邸、皇室住所、政府机关、行政大楼、使馆、境线、
        贵族、高贵、隐贵、上流、层峰、富人区、名门、阶层、阶级、
        国家大型赛事、冬奥会、奥林匹克运动会、世界杯、双十一、
        得房率%、亩、公里、平方米、热销亿、绿化率、%容积率、热销亿、热销、成交套、位业主、
        最、最佳、最具、最爱、最赚、最优、最优秀、最好、最大、最大程度、最高、最高级、最高档、最奢侈、最低、最低级、最低价、最底、
        最便宜、时尚最低价、最流行、最受欢迎、最时尚、最聚拢、最符合、最舒适、最先、最先进、最先进科学、最先进加工工艺、最先享受、最后、最后一波、最新、最新科技、最新科学、
        第一、先进、中国第一、全网第一、销量第一、排名第一、唯一、第一品牌、NO.1、TOP.1、独一无二、全国第一、一流、一天、仅此一次(一款)、最后一波、全国大品牌之一、
        国家级、国家级产品、全球级、宇宙级、世界级、顶尖、尖端、顶级工艺、顶级享受、高级、极品、极佳、绝佳、终极、极致、
        首个、首选、独家、独家配方、首发、全网首发、全国首发、网独家、首次、首款、全国销量冠军、国家级产品、国家、国家免检、国家领导人、填补国内空白、中国驰名(驰名商标)、国际品质、
        大牌、金牌、名牌、王牌、领袖品牌、遥遥、领先、领导者、缔造者、创领品牌、领先上市、巨星、著名、掌门人、至尊、巅峰、奢侈、优秀、资深、领袖、之王、王者、冠军、
        史无前例、前无古人、永久、万能、祖传、特效、无敌、纯天然、100%、高档、正品、真皮、超赚、精准、
        老字号、中国驰名商标、特供、专供、专家推荐、质量免检、无需国家质量检测、免抽检、国家领导人推荐、国家机关推荐、
        点击领奖、恭喜获奖、全民免单、点击有惊喜、点击获取、点击转身、点击试穿、点击翻转、领取奖品、
        秒杀、抢爆、再不抢就没了、不会更便宜了、没有他就、错过就没机会了、万人疯抢、全民疯抢、抢购、卖、抢疯了、
        今日、今天、几天几夜、倒计时、趁现在、就、仅限、周末、周年庆、特惠趴、购物大趴、闪购、品牌团、 精品团、单品团、习近平、推荐、100%、点击、中央、
        防治、消除、国际、省级、国际标准、
        CBD坐标、CBD核心、城市核心地段、你在城心、我在你心、中央、中心、重心、中枢、腹地、地标、城市中央、凌驾于世界之上、中心、重点、安全、全面、
        优质、得到、首个、独有、稀缺、必须、第1、第2、第3、超级、高效、投资回报、高端、绝不、第一、第二、成交、学校、极好、一体化、
        绝对高端、绝对实用、绝对贴身、绝对合适、绝对新潮、绝对推荐、绝对实惠、秒杀全网、全网低价、全网首家、全网抄底、全网受欢迎、全网之冠、全网之王、全网销量冠军、
        极致体验、极致工艺、极致追求、性能极强、性能极佳、极佳、极强、将、做到极致、独家原创、唯一设计、独家材质、独家做工、唯一渠道、唯一选择、独家工艺、唯一授权
        、全国第一、人气第一、行业第一、口碑第一、淘宝第一、排名第一、全网最低、击穿低价、全网秒杀、史上最低、行业第一、排名第一、绝不、
        跳楼价、清仓价、假一赔万、特价仅此一天、最后一小时、必定、显著、雄厚、专家、龙头、龙头企业、百年、王、专业、绝佳、
        珍稀、知名、超低、精品、全方位、无毒、天然、持久、一定、精确、达到优等水平、典范、终、独特、首创、必要、更、优势、少数名族、永远、促进、
        无限、率先、首批、明目、领导、美国、权威、休养生息、千年、全球、清除、完全、极大、帝都、首家、中央、不凡、独具、保健、一切";
        $ac=explode('、',$o);
        return str_replace($ac,'',$data);
    }

}
