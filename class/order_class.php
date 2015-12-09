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
            $relset= $this->dblink->db_read('`order`', '', 'uid', "$this->uid",$rows);
            if($rows){
            while ($row = mysql_fetch_array($relset)) {
                $temp[] = $row;
            }
            return $temp;
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
    