<?php

    //这是用户中心，包含注册、登录、退出、个人中心、修改资料、实名认证等

    class user_Mod {

        private static $uid;
        private static $uname;
        private static $uteam;
        public $temp;


        //连接数据库
        private static function user_sql(){
            $db_conn = new db_union_mysql();
            return $db_conn;
        }

        //个人中心


        //修改资料


        //实名认证



        //登出








































        //读取用户基本数据
        public static function getVal() {
            //连接数据库
            $db_conn = new db_union_mysql();

            //从 session[uid]里获取数据库内的用户基本信息
            $data = $db_conn->db_read('u_user', '', 'uid', "$_SESSION[uid]");            
            $data = self::setData($data);
            return $data;
        }

        //设置相关参数
        public function setData($data) {

            //设置性别
            $data['u_sex'] = $data['u_sex'] ? '男' : '女';
            //设置实名认证
            $data['u_real'] = $data['u_real'] ? 1 : 0;
            //设置等级图片显示
            $data['level'] = floor($data['level']/50).'.png';
            
            return $data;
        }
        
        //实名认证
        public static function real($set) {
            //判断有没有通过实名认证，如果没有，则开始，有则返回
            $db_link = new db_union_mysql();
            switch ($set) {
                case 'set':
                    if($_POST){
                        $data['name'] = $_POST['name'];
                        $data['card_type'] = $_POST['card_type'];
                        $data['card_id'] = $_POST['card_id'];
                        $data['card_img'] = $_POST['card_img'];
                        $data['card_img_2'] = $_POST['card_img_2'];
                        $data['rid']=$db_link->db_select_id(db_id, $_SESSION[uid], '该用户的实名认证记录')[num];
                        $real=$data['rid'];
                        $real=$db_link->db_inset('`real`', '', "$_SESSION[uid],$data[rid],'$data[name]',"
                                . "'$data[card_type]',$data[card_id],'$data[card_img]','$data[card_img_2]',now(),null,null");
                        //更新实名认证状态记录
                        $real = $db_link->db_edit('user', 'u_real=1', "uid=$_SESSION[uid]");
                    }
                    break;

                default:$real = $db_link->db_read('`real`', '', 'uid', $_SESSION[uid]);
                    break;
            }
            $db_link->db_closemysql($db_link, $real);
            return $real ? $real : NULL;
        }

    }
    