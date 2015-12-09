<?php
    session_start();
    
    //设定字符格式
    header("Content-Type:text/html;charset=utf-8");
    
    //根据操作系统确定是'/'还是'\'，并用全局常量 DS 存储
    define('DS', DIRECTORY_SEPARATOR);
    
    //确定文件系统根目录
    define('ROOT', dirname(__FILE__));
    
    //确定网址域名
    define('WWW_PATH', $_SERVER[SERVER_NAME]);


    require_once ROOT.'/themes/union_start.php';
    
    echo "this is secret";