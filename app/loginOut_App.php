<?php

    //这是一个判断用户是登录、注册、还是退出的程序控制器
    class login_App {

        public static $act;
        public static $data;
        public static $tmp;

        function __construct($val) {


            //正确加载本魔术方法，说明用户请求的是登录、注册页面，判断$val 的值是否为真，如果为 null，则默认为登录操作
            //否则，根据该 val 来加载相应的组件程序并执行;
            switch ($val[0]) {
                case 'regsiter': if (!$_POST) {
                        include ROOT . DS . VIEW . DS . 'regsiter.html';
                    } else {
                        $this->regsiter();
                    }
                    break;

                case 'logout':self::logout();
                    break;

                default: if (!$_POST) {
                        include ROOT . DS . VIEW . DS . 'login.html';
                    } else {
                        $this->login();
                    }

                    break;
            }
        }
       
        public static function logout() {
            session_unset();
            self::jump_page();
        }
        
        public static function login(){
            global $user_type;
            $secret_user = new login_out_Mod();
            
            if($secret_user->login()){
                echo $_SESSION['team'];
                foreach ($user_type as $key => $val){
                    
                    if($_SESSION['team'] >= 1){
                        self::jump_page("user,index");
                    }else {
                        self::jump_page('admin,index');
                }
                }
                
            }
            
        }
        
        public static function regsiter() {
            
            $secret_user = new login_out_Mod();
            if($user=$secret_user->regsiter()){
                self::jump_page('user,index'); 
            }
        }
        
        
        private static function jump_page($url){
            $http_uri = new path();
            $http_uri = $http_uri->make_path($url); 
            header("Location: $http_uri");  
        }

    }
    