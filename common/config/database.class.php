<?php
define("HOST","localhost");
define("DBNAME","oule");
define("USERNAME","root");
define("DBPWD","root");

class database{

    private $conn;

    public function __construct(){

        $this->conn= new mysqli(HOST,USERNAME,DBPWD,DBNAME);
        if($this->conn->connect_error){
            die('connection error'.$this->conn->connect_errno.'-'.$this->conn->connect_error);
        }
//        $db=mysql_select_db(DBNAME, $this->conn);
//        if(!$db){
//            die('there are problems with database'.mysql_errno($this->conn));
//        }
        mysqli_query($this->conn,'set names utf8');
    }
    public function getAssoc($sql){

        $query=$this->query($sql);

        $arr=array();
        $i=0;
        while($res=mysqli_fetch_assoc($query)){
            $arr[$i++]=$res;
        }

        $this->free($query);

        return $arr;

    }
    public function data($sql){
        $query=$this->query($sql);
        if(!$query){
            return $this->error();
        }else{
            $res=mysqli_fetch_assoc($query);
            $this->free($query);
            return $res;
        }

    }
    public function findData($sql){
        $query=$this->query($sql);
        if(!$query){
            return $this->error();
        }else{
            $res=$this->fetch_row($query);
            $this->free($query);
            return $res;
        }
    }
    public function error(){
       return mysqli_error($this->conn);
    }
    public function errno(){
        return mysqli_errno($this->conn);
    }
    public function fetch_row($query){
        $num=mysqli_fetch_row($query);

        return $num;
    }
    public function affected_rows(){
        return mysqli_affected_rows();
    }
    public function query($sql){

        $query=mysqli_query($this->conn,$sql);
        if(!$query){
            echo $this->errno().':'.$this->error();
        }

        return $query;
    }

    public function free($res){
        mysqli_free_result($res);
    }
    public function close(){
        if( !mysqli_close($this->conn) ) {
           mysqli_close($this->conn);
        }

    }
    public function __destruct(){
        if( !mysqli_close($this->conn) ) {
           mysqli_close($this->conn);
        }
    }
}
?>