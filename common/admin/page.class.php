<?php
class page extends dataAdopter {

    /***
     * 仅用于获取分页传过来的页码数
     * @return int
     */
    public function pagenow(){
        if(empty($_GET['pagenow'])){
            $pagenow=0;
        }else{

         $pagenow=$_GET['pagenow']-1;

        }

        return $pagenow;

    }

    /**
     * @param string $m     模型
     * @param string $v     视图
     * @param int $pid      父级id
     * @param int $num      显示条目数
     * @param int $count    数据总条数
     * @return string       返回分页html代码
     */
    public function paginate($m='',$v='',$pid=0,$num=0,$count=0){
        $next='';
        $prev='';
        $next_onclick='';
        $prev_onclick='';
//        $pageNums=5;#分页数
//        $aa=ceil($pageNums/2);
        $pagecount=ceil($count/$num);//总页码数

        if($pid=='' || $pid==null || empty($pid) || !isset($pid)){#拼接是否有传过来的pid
            $pid='';
        }else{
            $pid="&".$pid;
        }

        if(isset($_GET['pagenow']) && is_numeric($_GET['pagenow'])){
            $pagenow=$_GET['pagenow'];
            if($pagenow==$pagecount) {#当前页等于总页码数取消超链接网后跳转
                $next = 'disabled';
                $next_onclick='onclick="return false;"';
            }
            if($pagenow<=1){#当前页最小值为1的时候取消超链接往前跳转
                $prev = 'disabled';
                $prev_onclick='onclick="return false;"';
            }
        }else{
            $pagenow=1;#当前页值默认为1
            $prev = 'disabled';
            $prev_onclick='onclick="return false;"';
        }
        if($pagenow==1){#防止前后跳的超链接跳到负数或超出分页数 当前前跳链接数值-1，后跳相反
            $pagenow=1;
        }

        if($pagenow<=0){
            $pagenow=1;
        }
        $page_whole=3;#每固定页数后次页翻一次分页数
        $i=floor(($pagenow-1)/$page_whole)*$page_whole+1;
        $index=$i;
        $html="<nav aria-label='Page navigation'>";
        $html.="<ul class='pagination'>";
        $html.="<li class='{$prev}'><a href='?m={$m}&v={$v}&pagenow=".($pagenow-1)."{$pid}' {$prev_onclick}><span aria-hidden='true'>&laquo;</span></a></li>";
        for(;$i<$index+$page_whole;$i++){
            if($i==$pagenow){
                $html.="<li><a>$i</a></li>";
                continue;
            }
            $html.="<li><a href='?m={$m}&v={$v}&pagenow={$i}{$pid}'>$i</a></li>";
        }
        $html.="<li class='{$next}'><a href='?m={$m}&v={$v}&pagenow=".($pagenow+1)."{$pid}' {$next_onclick}><span aria-hidden='true'>&raquo;</span></a></li>";
        $html.="</ul>";
        $html.="</nav>";

        if($count<=$num){
            return null;
        }else{
            return $html;
        }

    }

    /**
     * 结算分页总数
     * @param string $table
     * @param string $column
     * @param string $where
     * @return mixed
     */
    public function pagecount($table,$column,$where=''){

        if($where=='' || $where==null || empty($where) || !isset($where)){
            $where='';
        }else{
            $where=" where ".$where;
        }
        $sql="select count(".$column.") from ".$table.$where;
        $query =$this->query($sql);
        $datacount=$this->fetch_row($query);
        return $datacount[0];
    }

    /**
     * get 的固定关键词 pagenow
     * @return string
     */
    public function page_id(){
        if(isset($_GET['pagenow'])){
            return '&pagenow='.$_GET['pagenow'];
        }else{
            return '&pagenow=0';
        }
    }
    final function url($url=array()){

        $urls=implode('&',$url);

        return "&".$urls;
    }
}


