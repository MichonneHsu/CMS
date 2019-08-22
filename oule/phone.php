<?php
include_once './app/common/home/ob.php';
include_once './app/common/config/database.class.php';
include_once './app/common/config/dataAdopter.class.php';
include_once './app/common/config/define.php';
include_once './app/common/config/phone.php';
$a= new dataAdopter();
if(isset($_GET['m']) && isset($_GET['v'])){
    include_once './app/phone/controller/'.$_GET['m'].'/'.$_GET['v'].'.php';
}else{
    include_once './app/phone/controller/index/index.php';
}


?>