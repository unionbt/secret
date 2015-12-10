<?php

    //主页的控制器
    class home_App {

        public $home_page;
        public $tmpData;

        function run() {
            $this->home_page='home.php';
            $this->getData();
            $this->home_view();
        }

        //加载头部
        //加载 banner
        //加载数据
        function getData(){
            $this->tmpData = 'loveyou union';
        }
        //显示视图
        function home_view() {
            $data=  $this->tmpData;
            include ROOT . DS . VIEW . DS . "$this->home_page";
        }

    }
    