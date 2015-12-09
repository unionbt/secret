<?php

    //个人中心的控制器
    class user_App {

        private static $user = array();
        private static $uid;
        private static $uname;
        public $temp;
        private static $order;
        private static $o_type;
                function __construct($option) {
            //判断有没有登录，没有则转到登录
            if (empty($_SESSION['uid'])) {
                new login_App();
            } else {

                //如果动作响应为退出，则调用 login_App 中的 logout 方法，否则，开始根据 session[uid]提取用户数据
                switch ($option['act']) {
                    case 'real':self::real($option['val']);
                        break;
                    case 'logout':login_App::logout();
                        break;

                    default :self::User_Begin();
                        break;
                }
            }
        }

        private static function User_Begin() {
            //加载用户中心核心模块，实例化该对象
            $abc = new user_Mod();
            //取用户中心的基本数据,并存储在user 数组中，包含：用户名 id 图像，性别，实名认证状态
            self::$user = user_Mod::getVal();
            //判断实名认证
            self::$user['r_img'] = self::$user['u_real'] ? 'themes/img/real.png' : 'themes/img/no_real.png';
            //设置等级
            self::$user['level'] = 'themes/img/level/' . self::$user['level'];

            //读取订单
            $orders = new order_App('r_order');
            $data = $orders->data;

            /*
             * 用数组 o_type 记录 待付款、待发货、待收货、待完成的订单数;
             * 其中，数据库中 o_if 的字段值，0：待付款（dfk)，1：待发小样(dxy)，2：待确认小样(dqr)，3：待发货(dfh)，
             *                          4：待收货(dsh)，5：待完成(dwc)，6：退款中(dtk),7:全部完成（ok)
             * 
             */
            $o_type['all'] = count($data);
            foreach ($data as $key => $value) {
                
                if (is_array($value)) {
                    switch ($value[o_if]) {
                        case 0: $o_type['dfk'] ++;
                            break;
                        case 1:$o_type['dxy'] ++;
                            break;
                        case 2:$o_type['dqr'] ++;
                            break;
                        case 3:$o_type['dfh'] ++;
                            break;
                        case 4:$o_type['dsh'] ++;
                            break;
                        case 5:$o_type['dwc'] ++;
                            break;
                        case 6:$o_type['dtk'] ++;
                            break;
                        case 6:$o_type['ok'] ++;
                            break;
                    }
                }
            }
            self::$o_type = $o_type;
            //显示个人中心，基中 self::$user 中的为用户数据， $o_type 中的为订单状态
            self::show();
        }

        //实名认证
        public static function real($set) {

            switch ($set) {
                case 'set':
                    $uReal = user_Mod::real($set);
                    if ($uReal)
                        echo '您提交的资料已收到，我们将在3 个工作日对您的资料进行审核，祝你购物愉快';
                    break;
                case 'write':
                    include ROOT . DS . VIEW . DS . 'real.html';

                //获取实名认证信息
                default:$uReal = user_Mod::real();
                    break;
            }
            return $uReal;
        }

        function show() {
            $order = self::$o_type;
            $show_data = self::$user;
            include ROOT . DS . VIEW . DS . 'user.html';
        }

    }
    