<?php

include_once 'session.php';
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 15:11
 */
class verify
{
    public function code_numbers($vc){
        $verify_codes=$vc;

        $img_width=40;
        $img_height=20;
        $image= imagecreatetruecolor($img_width,$img_height);
        $white= imagecolorallocate($image,255,255,255);
        $black= imagecolorallocatealpha($image,0,0,0,63.5);
        imagefilledrectangle($image,1,1,40,20,$white);
        imagestring($image,10,2,2,$verify_codes,$black);
        header("Content-type: image/png");
        imagepng($image);
        imagedestroy($image);


    }
    public function verify_code(){

        $num=range(0,10);
        $alphabet=range('a','z');
        $Capital_alphabet=range('A','Z');
        $merge=array_merge($num,$alphabet,$Capital_alphabet);
        $merged_code=implode('',$merge);
        $shuffle_codes=str_shuffle($merged_code);
        $verify_codes=substr($shuffle_codes,0,4);

        return $verify_codes;
    }
    public function getvc(){
       return strtolower($this->verify_code());
    }
    public function check_codes($codes){
        if($codes==$_SESSION['verify_codes']){
           return 1;
        }else{
            return 0;
        }
    }
}

$verify = new verify();

$vc=null;




if(isset($_GET['vc'])){
    if($_GET['vc']==1){
        $vc=$verify->getvc();
        $_SESSION['verify_codes']=$vc;
        $verify->code_numbers($vc);
    }else if($_GET['vc']==2){
        echo $vc;
    }else if($_GET['vc']==3){
            if(isset($_GET['codes'])){
               echo $verify->check_codes($_GET['codes']);
            }

    }

}

?>
