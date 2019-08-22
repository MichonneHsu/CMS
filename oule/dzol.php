<?php
include_once './app/common/config/session.php';
$stime=microtime(true);

include_once './app/common/config/dataAdopter.class.php';
include_once './app/common/config/define.php';
include_once './app/common/config/upload.class.php';
include_once './app/common/admin/page.class.php';


if(isset($_SESSION['user'])){
    if(isset($_GET['m']) && isset($_GET['v'])){
        $m=$_GET['m'];
        $v=$_GET['v'];
        include_once './app/admin/controller/'.$m.'/'.$v.'.php';

    }else{
        include_once './app/admin/controller/index/index.php';
    }
}else{
    include_once './app/admin/controller/login/login.php';
}

$etime=microtime(true);
$total=$etime-$stime;
echo "<br />[页面执行时间：{$total} ]秒";
echo "<br/>消耗的内存为：".(memory_get_peak_usage(true) / 1024 / 1024)."M";
