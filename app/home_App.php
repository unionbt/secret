<?php

    //主页的控制器
    class home_App {

        public $home_page;
        public $tmpData;

        function __construct() {
            $this->home_page='home.php';
            $this->getData();
        }

        //加载头部
        //加载 banner
        //加载数据
        function getData(){
            $this->tmpData = 'loveyou union';
        }
        //显示视图
        function __destruct() {
            $data=  $this->tmpData;
            include ROOT . DS . VIEW . DS . "$this->home_page";
        }

    }
    