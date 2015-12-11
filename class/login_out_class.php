<?php
    
    class login_out_Mod{
    
        static $data;

        //登录
        public function login() {

            //加载相应的数据后，加载页面？
            self::setdata();
            return self::getData();  
        }
        
        //注册
        public function regsiter() {
            self::setdata();
            $reg = self::wirteData();
            
            //创建用户目录
                global $usdir;
                $dir = ROOT.DS.US.DS.self::$data[name];
                if(!is_dir($dir)){
                    for($i=0;$i<count($usdir);$i++){
                        $newdir= $dir.DS."$usdir[$i]";
                        fileupload::create_folders($newdir);
                    }
                    
                }
                
                return $reg;
        }

        
        //获取数据
        public static function getData() {
            $dbLink = new db_union_mysql();            
            if (!$db_dataUid = $dbLink->db_read('u_user', 'uid,u_name,u_pass', 'uid', self::$data['name'])) {
                if (!$db_dataU_name = $dbLink->db_read('u_user', 'uid,u_name,u_pass', 'u_name', self::$data['name'])) {
                    if (!$db_dataU_phone = $dbLink->db_read('u_user', 'uid,u_name,u_pass', 'u_phone', self::$data['name'])) {
                        $error = new error_App('4');
                    } else {
                        $login = self::db_with($db_dataU_phone);
                    }
                } else {
                    $login = self::db_with($db_dataU_name);
                }
            } else {
                $login = self::db_with($db_dataUid);
            }
            $dbLink->db_closemysql($dbLink);
            return $login;
        }

        //格式化获取到的数据
        public static function setdata() {
            self::$data['name'] = $_POST['name'];
            self::$data['pass'] = md5($_POST['pass']);
            self::$data['u_phone'] = $_POST['u_phone'];
            self::$data['sex'] = $_POST['sex'];
        }

        //数据比较，用于用户登录鉴权等
        public static function db_with($val) {
            if (self::$data['pass'] == $val['u_pass']) {
                $_SESSION['uid'] = $val['uid'];
                $_SESSION['login'] = 1;
                return TRUE;
            } else {
                $loginErr = new error_App('loginErr');
            }
        }
        
        //创建新用户写入数据库
       public static function wirteData(){
           //连接数据库
           $dbLink = new db_union_mysql();
           //创建全局id索引表
           $id=$dbLink->db_select_id('u_user', 'user_reg',HOST_USER, '创建新用户');
           
           //如果创建一个全局id成功，就开始写入用户列表，用数组 $id['ok']的值来判断是否写入数据库中成功，成功则开始写入数据库u_user表中
           if($id['ok']){
               $db = self::$data;
               $id['ok'] = $dbLink->db_inset('u_user', '', "$id[id],NULL,'$db[name]',$db[u_phone],
                       NULL,NULL,NULL,'$db[pass]','0.png',1,$db[sex],0,now(),'$_SERVER[SERVER_ADDR]'");
           }  else {
               //全局注册失败，返回一个错误号
               $writeErr = new error_App('user_reg');
           }
           
           //注册成功，执行写入操作并关闭数据库
           $dbLink->db_closemysql($dbLink,$id['ok']);
           
           //在session中记录相应的用户帐号和登录状态
           $_SESSION['uid'] = $id['id'];
           $_SESSION['login'] = 1;
           return TRUE;
       }
        
        
    
    }