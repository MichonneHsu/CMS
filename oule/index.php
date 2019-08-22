<?php


    include_once './app/common/home/ob.php';

include_once './app/common/config/database.class.php';
include_once './app/common/config/session.php';
    include_once './app/common/config/dataAdopter.class.php';
    include_once './app/common/config/define.php';
    include_once './app/common/config/verify.php';
    include_once './app/common/home/page.class.php';



    if(isset($_GET['m']) && isset($_GET['v'])){
        $m=$_GET['m'];
        $v=$_GET['v'];
        include_once './app/home/controller/'.$m.'/'.$v.'.php';
    }else{
        include_once './app/home/controller/index/index.php';
    }

//$s=$_SERVER;
//echo $s['SERVER_NAME'].$s['REQUEST_URI'];


?>

