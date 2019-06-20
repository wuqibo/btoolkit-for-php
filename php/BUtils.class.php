<?php
include_once 'define.php';
include_once 'RSATool.class.php';

class BUtils{

    //设置本地默认时间
    static function setDateDefaultTimezone(){
        date_default_timezone_set("Asia/Shanghai");
    }

    //存储Session
    static function setSession($key,$value){
        if(!session_id())session_start();
        $_SESSION[$key] = $value;
    }

    //读取Session
    static function getSession($key){
        if(!session_id())session_start();
        if(isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    //服务器：获取自定义的header数据
    static function getAllHeaders(){
        $ignore = array('host','accept','content-length','content-type');
        $headers = array();
        foreach($_SERVER as $key=>$value){
            if(substr($key, 0, 5)==='HTTP_'){
                $key = substr($key, 5);
                $key = str_replace('_', ' ', $key);
                $key = str_replace(' ', '-', $key);
                $key = strtolower($key);
                if(!in_array($key, $ignore)){
                    $headers[$key] = $value;
                }
            }
        }
        return $headers;
    }

    //获取当前页面的名字
    static function getCurrPageName(){
        $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
        return $php_self;
    }

    //获取当前页面的名字
    static function getParamsFromUrl(){
        $params = $_SERVER['QUERY_STRING'];
        if(!empty($params)){
            return $params;
        }
        return '';
    }

    //获取不带参数的完整url
    static function getFullURLWithoutParams(){
        $urlProtocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $url = $urlProtocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        return $url;
    }

    //获取当前页面的完整url
    static function getFullURL(){
        $urlProtocol = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $url = $urlProtocol.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        $params = $_SERVER['QUERY_STRING'];
        if(!empty($params)){
            $url = $url.'?'.$params;
        }
        return $url;
    }

    //本页不缓存
    static function dontCache(){
        header("Cache-control:no-cache,no-store,must-revalidate");
        header("Pragma:no-cache");
        header("Expires:0");
    }

    //获得当前时间
    static function getTimeNow(){
        self::setDateDefaultTimezone();
        return date("Y-m-d H:i:s");
    }

    //显示日期
    static function date(){
        return date("Y年m月d日");
    }

    //显示星期
    static function week(){
        return " 星期".mb_substr( "日一二三四五六",date("w"),1,"utf-8" );
    }

    //设置页面编码
    static function setPageCharset(){
        header("Content-type: text/html; charset=utf-8");
    }

    //判断字符串里是否存在某个字符串
    static function equals($str1,$str2){
        return strcmp($str1,$str2)==0;
    }

    //判断字符串里是否存在某个字符串
    static function containsStr($strAll,$strSub){
        return strpos($strAll,$strSub)!==false;
    }

    //截取文章前几个字并去掉效果
    static function getTextSub($centent,$length){
        $centent = preg_replace("/<[^>]+>/", '', $centent);
        return mb_substr($centent, 0, $length, 'utf-8');
    }

    //删除文件
    static function deleteFile($fileFullPath){
        if(is_file($fileFullPath)){
            unlink($fileFullPath);
        }
    }
	
	//删除文件夹
	static function deleteFolder($path){
	    if(!is_dir($path)){
            return null;
		}
		$fh = opendir($path);
		while(($row = readdir($fh)) !== false){
			if($row == '.' || $row == '..'){
				continue;
			}
			if(!is_dir($path.'/'.$row)){
				unlink($path.'/'.$row);
			}
			BUtils::deleteFolder($path.'/'.$row);
		}
		closedir($fh);
		if(!rmdir($path)){
			echo $path.'无权限删除<br>';
		}
		return true;
	}

    //写入文本文件
    static function saveText($fullPath,$content){
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);//true代表递归创建子文件夹
        }
        file_put_contents($fullPath, $content, FILE_APPEND);
    }

    //Curl以Post方式提交Xnl并立即返回结果
    static function curlPostJson($url,$jsonStr){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length:'.strlen($jsonStr)));
        $result = curl_exec($ch);
        if($result){
            curl_close($ch);
            return $result;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return 'error:'.$error;
        }
    }

    //Curl以Get方式返回结果
    static function curlGet($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch); // 已经获取到内容，没有输出到页面上。
        if($result){
            curl_close($ch);
            return $result;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return 'error:'.$error;
        }
    }
    
    //去掉文件名后缀
    static function removeFileNameSuffix($fileFullName){
        $fileNameNoSuffix = str_replace(strrchr($fileFullName, "."),"",$fileFullName);
        return $fileNameNoSuffix;
    }
}