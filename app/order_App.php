<?php

    class order_App{
    
        public $data = array();
        public $o_mod;
                
        function __construct($act) {
            $this->o_mod = new order_Mod();
            self::$act();
        }
        
        //查看订单
        public function r_order($rows){
            
            $this->data = $this->o_mod->o_read(1);
        }




        //增加订单
    function a_order(){
        
    }
        
//        修改订单
        function u_order(){
            
        }
        
        //删除订单
        function d_order(){
            
        }
        
        //支付、结算
        function p_order(){
            
        }
        
    }