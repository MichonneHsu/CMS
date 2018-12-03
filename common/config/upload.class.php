<?php

/**
 * Class upload
 * 随机文件名防止重复
 * 上传路径
 * #控制文件大小
 * 限制上传文件类别
 */

class upload{
    private $config=array(
        'savePath'=>SAVEPATH,
        'otherPath'=>OTHERPATH,
        'fileType'=>array('jpg','png','jpeg'),
        'fileSize'=>1000000
    );
    public function config(){
        return $this->config;
    }
    function saveName(){
        return mb_strcut(hash('md5',time().rand(0,100)),'0','13');
    }

    /***
     * 获取图片信息
     * @param $name
     * @return string 返回图片类别
     */
    function filetype($name){
        $info=getimagesize($name);
        $image_type=image_type_to_extension($info[2],0);
        if(in_array($image_type,$this->config['fileType'])){
            if($image_type=='jpeg'){
                return 'jpg';
            }else{
                return $image_type;
            }

        }else{
            die('非法格式上传');
        }

    }

    /**图片上传
     * 文件错误号 = 2 图片上传有误，程序走完就返回文件名称，反则返回空字符串
     * @param $file
     * @return string
     */
    public function movefile($file,$root=''){

        if($root=='' || empty($root)){
            $root=$this->config['savePath'];
        }else{
            $root=$root;
        }
            $name="";
            if($file['error']== UPLOAD_ERR_OK){
                if($file['size'] > $this->config['fileSize']){
                    die('图片大小过大');
                }
                $tmp_name=$file['tmp_name'];
                $name=$file['name']=$this->saveName().'.'.$this->filetype($tmp_name);
                if(move_uploaded_file($tmp_name,$root.$name)){
                    return $name;
                }else{
                    return 0;
                }

            }

    }

    /**多图片上传
     * 文件错误号 = 1 图片上传有误，程序走完就返回文件名称
     * @param $file
     * @param $path
     * @return array
     */
    public function move_multi_file($file,$path=""){

        if(!$path){
            $path=$this->config['savePath'];
        }
        $arr=array();
        $name='';
        foreach($file['error'] as $k=>$v){
            if( $v == UPLOAD_ERR_OK ){
                $tmp_name=$file['tmp_name'][$k];
                $name=$file['name'][$k]=$this->saveName().'.'.$this->filetype($tmp_name);
                if(move_uploaded_file($tmp_name,$path.$name)){
                    $arr[$k]=$name;
                }
            }
        }

        return $arr;

    }
}
