<?php

//超级用户的管理员后台,
//功能：用户管理    显示、删除、增加、查找
//     卖家管理    增加、查找、修改、删除、审核
//     推客管理    增加、查找、修改、删除、审核
//     订单管理    订单统计、查找、修改、删除
//     财务管理    财务统计、流水
//     组权限管理   帐户分组权限增加、修改
//     文件管理     文件查找、修改、删除

class admin_App {

    function __construct( $val ) {
        echo 'index';
        
    }

    

    //超级管理员后台首页
    private static function admin() {
        echo '显示首页';
    }

    //用户管理
    private static function admin_user() {
        
    }

    //卖家管理
    private static function admin_sale() {
        
    }

    //推客管理
    private static function admin_mission() {
        
    }

    //订单管理
    private static function admin_order() {
        
    }

    //财务管理
    private static function admin_money() {
        
    }

    //用户组管理
    private static function admin_team() {
        
    }

    //文件管理
    private static function admin_file() {
        
    }

}
