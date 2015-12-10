<?php
    
    class login_out_Mod{
    
        static $data;

        //登录
        public function login() {

            //加载相应的数据后，加载页面？
            self::setdata();
            self::getData();   
        }
        
        //注册
        public function regsiter() {
            self::setdata();
            self::wirteData();
        }

        public static function getData() {
            $dbLink = new db_union_mysql();
            $val = self::$data['name'];
            
            if (!$db_dataUid = $dbLink->db_read('u_user', 'uid,u_name,u_pass', 'uid', "$val")) {
                if (!$db_dataU_name = $dbLink->db_read('u_user', 'uid,u_name,u_pass', 'u_name', "$val")) {
                    if (!$db_dataU_phone = $dbLink->db_read('u_user', 'uid,u_name,u_pass', 'u_phone', "$val")) {
                        $error = new error_App('4');
                    } else {
                        self::db_with($db_dataU_phone);
                    }
                } else {
                    self::db_with($db_dataU_name);
                }
            } else {
                self::db_with($db_dataUid);
            }
            $dbLink->db_closemysql($dbLink);
        }

        public static function setdata() {
            self::$data['name'] = $_POST['name'];
            self::$data['pass'] = md5($_POST['pass']);
            self::$data['u_phone'] = $_POST['u_phone'];
            self::$data['sex'] = $_POST['sex'] ? '男' : '女';
        }

        public static function db_with($val) {
            $data = $val;
            if (self::$data['pass'] == $data['u_pass']) {
                $_SESSION['uid'] = $data['uid'];
                $_SESSION['name'] = $data['u_name'];
                //跳转到用户中心
                new user_App();
            } else {
                echo "密码错误";
            }
        }
        
       public static function wirteData(){
           //连接数据库
           $dbLink = new db_union_mysql();
           //创建全局id索引表
           $id=$dbLink->db_select_id('u_user', 'user_reg',HOST_USER, '创建新用户');
           if($id['ok']){
               $db = self::$data;
               $id['ok'] = $dbLink->db_inset('u_user', '', "$id[id],NULL,'$db[name]',$db[u_phone],
                       NULL,NULL,NULL,'$db[pass]','0.png',1,'$db[sex]',0,now(),'127.0.0.1'");
           }  else {
               $writeErr = new error_App('user_reg');
           }
           
           //注册成功，执行写入操作并关闭数据库
           $dbLink->db_closemysql($dbLink,$id['ok']);
           //转入个人中心
           $_SESSION['uid'] = $id['id'];
           return $id;
       }
        
        
    
    }