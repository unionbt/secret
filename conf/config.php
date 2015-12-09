<?php

    //视图文件夹
    //判断流览器类型，checkmobile 返回为真，则是手机浏览器;今后如开发 app 客户端，则还应加入一个客户端的识别;
    if (checkmobile()) {
        define('VIEW', 'themes'.DS.'mob');
    }  else {
        define('VIEW', 'themes');
    }
    
    //数据库服务器名
    define('HOST','localhost');
    //数据库用户名
    define('HOST_USER', 'root');
    //数据表
    define('HOST_TAB','union');
    //数据库密码
    define('HOST_PASS', 'danlp0928');
    //用户目录
    define('US', 'user');
    //用户目录分支
    $usdir = array('img','doc','muisc','log');
    
    
    
    define('BIGNUM','999989999'); //全局最大的数据库记录个数，超过这个，将扩容//

    
    //商品类型
    $prod_type = array(1=>"女装",2=>"男装",3=>"美食",4=>"数码",5=>"新奇特",6=>"预定");
    //商品预定(待定)
    //$prod_buynow = array(1=>"预定",2=>"发售");
    
    
    //会员注册、登陆类型
    $user_type = array(1=>"超级分享家",2=>"设计师",3=>"制造商",4=>"审核员",5=>"管理员",6=>"卖家",7=>"超级管理");
    //商品状态
    $prod_zhuantai = array(1=>"待审核",2=>"通过",3=>"不通过");
?>