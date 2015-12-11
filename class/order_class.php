<?php

    //订单

    class order_Mod {

        public $uid;
        public $oid;
        public $dblink;

        function __construct() {
            $this->dblink = new db_union_mysql();
            $this->uid=$_SESSION['uid'];
        }

        //查看订单
        public function o_read($rows) {
            $relset= $this->dblink->db_read('un_order', '', 'uid', "$this->uid",$rows);
            //如果读到订单，则用$temp存储订单信息，然后返回数据
            if($rows){
            while ($row = mysql_fetch_array($relset)) {
                $temp[] = $row;
            }
            return $temp;
            //否则，返回为假
        }  else {
            return $relset;
        }
        }
        //增加
        //修改
        //结算
        //订单状态跟进
        //计算订单金额、分配佣金
    }
    