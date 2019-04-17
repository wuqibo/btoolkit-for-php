<?php
include_once 'define.php';

class DB {

    static $pdo;

    //链接MySql，不链接任何建立的库
    static function connect_mysql() {
        self::$pdo = new PDO("mysql:host=".DB_IP,DB_ID,DB_PW);
        if (!self::$pdo) {
            return false;
        }
        return true;
    }

    //判断本站所用的数据库是否已创建
    static function has_db(){
        try {
            new PDO("mysql:host=".DB_IP.";dbname=".DB_NAME,DB_ID,DB_PW);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    //判断本站所用的数据库是否已创建
    static function has_table($table){
        if(!isset(self::$pdo)){
            self::connect_db();
        }
        $result = self::$pdo->query("show tables like '". $table."'");
        $row = $result->fetchAll();
        return ('1' == count($row));
    }

    //创建数据库
    static function create_db(){
        return self::$pdo->query("create database if not exists ".DB_NAME);
    }

    //删除数据库
    static function delete_db(){
        if(!isset(self::$pdo)){
            self::connect_mysql();
        }
        return self::$pdo->query("drop database if exists ".DB_NAME);
    }

    //链接数据库
    static function connect_db() {
        self::$pdo = new PDO("mysql:host=".DB_IP.";dbname=".DB_NAME,DB_ID,DB_PW);
        if (self::$pdo) {
            return true;
        }
        return false;
    }

    //执行query语句
    static function query($sql){
        return self::$pdo->query($sql);
    }

    //执行exec语句
    static function exec($sql){
        self::$pdo->exec($sql);
    }

}