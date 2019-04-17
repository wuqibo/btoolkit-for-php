<?php

class Upload {
    public $postFile;
    public $error;
    public $fileName;
    public $suffix;
    public $fileWidth;
    public $fileHeight;
    public $md5;

    function Upload($postFile, $limitMB, $suffix=null) {
        $this->postFile = $postFile;
        $this->fileName = $this->postFile['name'];
        if(isset($suffix)){
            $this->suffix = '.' . $suffix;
        }else {
            $this->suffix = '.' . pathinfo($this->postFile['name'], PATHINFO_EXTENSION);
        }
        if ($this->postFile['error'] > 0) {
            $code = $this->postFile['error'];
            if ($code == 4) {
                $this->error = '未选择文件';
            } else if ($code == 1) {
                $this->error = '文件大小必须小于' . $limitMB . 'M';
            } else {
                $this->error = '上传错误: Code ' . $code;
            }
        } else if ($this->postFile["size"] >= ($limitMB * 1024 * 1024)) {
            $this->error = '文件大小必须小于' . $limitMB . 'M';
        } else {
            if (strcmp($this->suffix, '.jpg') == 0 || strcmp($this->suffix, '.jpeg') == 0 || strcmp($this->suffix, '.png') == 0 || strcmp($this->suffix, '.gif') == 0) {
                $sizeInfos = getimagesize($this->postFile['tmp_name']);
                $this->fileWidth = $sizeInfos[0];
                $this->fileHeight = $sizeInfos[1];
                $this->md5 = md5_file($this->postFile['tmp_name']);
            }
        }
    }

    //获取上传的额外参数
    function getExtraParam($key){
        return $this->postFile[$key];
    }

    //保存文件
    function saveFile($savePath, $fileName) {
        if (!isset($this->error)) {
            if (!file_exists($savePath)) {
                mkdir($savePath, 0777, true);//true代表递归创建子文件夹
            }
            return move_uploaded_file($this->postFile['tmp_name'], $savePath . '/' . $fileName);
        }
        return false;
    }
}