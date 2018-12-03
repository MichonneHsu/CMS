<?php

class islogin
{
    public function haslog()
    {
        if($this->status()==0){
            header('Location:?m=login&v=login');
        }
    }

    public function set($name,$data,$expire=600){
        $session_data=array();
        $session_data['data']=$data;
        $session_data['expire']=time()+$expire;
        $_SESSION[$name]=$session_data;

    }
    public function get($name){
        if(isset($_SESSION[$name])){
            if($_SESSION[$name]['expire']>time()){
                return $_SESSION[$name]['data'];
            }else{
                $this->clear($name);
            }
        }
    }
    public function clear($name){
        unset($_SESSION[$name]);
    }
   
}


