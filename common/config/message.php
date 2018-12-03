<?php




include_once "session.php";
include_once "database.class.php";
include_once "dataAdopter.class.php";
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/17
 * Time: 9:37
 */
class message extends dataAdopter
{

    public function msg_insert(){

        $post=array();
        if($_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest'){

            if($_POST){

                    $post['customer_name']=$_POST['customer_name'];
                    $post['customer_tel']=$_POST['customer_tel'];
                    $post['customer_email']=$_POST['customer_email'];
                    $post['customer_question']=$_POST['customer_question'];
                    $post['customer_insert_date']=time();
                    $status=$this->add('zr_customer',$post);

                    if($status){
                        echo 1;
                    }else{
                        echo 0;
                    }


            }
        }
    }
}
$message= new message();

if($_GET){
    if(isset($_GET['getmsg'])&& $_GET['getmsg']==1) {
        $message->msg_insert();
    }
}




