<?php
include_once 'BUtils.class.php';
include_once 'DB.class.php';

class Installer {
    static function install($adminAcount,$adminPassword,$adminEmail) {
        echo '<br>创建数据库...';
        if (!DB::connect_mysql()) {
            echo '<p style="color:#ff0000">无法连接数据库</p>';
        }
        //数据库
        if (DB::create_db()) {
            echo '完成';
            if(DB::connect_db()) {
                if (self::createTableUsers($adminAcount,$adminPassword,$adminEmail)) {
                    if (self::createTableTokens()) {
                        if (self::createTablePhotos()) {
                            if (self::createTableCollects()) {
                                return true;
                            }
                        }
                    }
                }
            }
        }else{
            echo '<p style="color:#ff0000">失败</p>';
        }
        return false;
    }

    static function createTableUsers($account,$password,$email){
        echo '<br>创建会员表...';
        $sql = "create table if not exists ".TABLE_USERS."
(
id int not null auto_increment,
primary key(id),
account varchar(15),
password varchar(64),
photo varchar(64),
email varchar(15),
create_time timestamp not null default current_timestamp
)";
        if(DB::query($sql)) {
            $result = DB::query("select * from ".TABLE_USERS." where account='".$account."'");
            if($result->rowCount()==0) {
                DB::exec("insert into " . TABLE_USERS . " (account,password,email) values ('" . $account . "','" . md5($password) . "','" . $email . "')");
            }
            echo '完成';
            return true;
        }else{
            echo '<span style="color:#ff0000">失败</span>';
            return false;
        }
    }

    static function createTableTokens(){
        echo '<br>创建Token表...';
        $sql = "create table if not exists ".TABLE_TOKENS."
(
id int not null auto_increment,
primary key(id),
token varchar(32),
create_time timestamp not null default current_timestamp
)";
        if(DB::query($sql)) {
            echo '完成';
            return true;
        }else{
            echo '<span style="color:#ff0000">失败</span>';
            return false;
        }
    }

    static function createTablePhotos(){
        echo '<br>创建图片表...';
        $sql = "create table if not exists ".TABLE_PHOTOS."
(
id int not null auto_increment,
primary key(id),
photo varchar(64),
kind varchar(10),
account varchar(32),
create_time timestamp not null default current_timestamp
)";
        if(DB::query($sql)) {
            echo '完成';
            return true;
        }else{
            echo '<span style="color:#ff0000">失败</span>';
            return false;
        }
    }
	
    static function createTableCollects(){
        echo '<br>创建收藏表...';
        $sql = "create table if not exists ".TABLE_COLLECTS."
(
id int not null auto_increment,
primary key(id),
account varchar(32),
photo_id int,
create_time timestamp not null default current_timestamp
)";
        if(DB::query($sql)) {
            echo '完成';
            return true;
        }else{
            echo '<span style="color:#ff0000">失败</span>';
            return false;
        }
    }

    static function uninstall() {
        echo '正在删除数据库...';
        if(DB::delete_db()) {
            echo '完成';
            return true;
        }else{
            echo '<span style="color:#ff0000">失败</span>';
            return false;
        }
    }
}