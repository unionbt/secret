<?php

//涵数开始
class db_union_mysql {

    private static $act;
    private static $return;
    private static $error;
    private static $lange;

    function __construct() {
        $this->db_linkmysql();
        $this->db_begin('start');
    }

    //连接数据库
    function db_linkmysql() {
        mysql_connect(HOST , HOST_USER , HOST_PASS);
        mysql_select_db(HOST_TAB) or die('连接数据库失败' . mysql_error());
        mysql_query("set names utf8");
    }

    //基本功能涵数
    function db_query( $v ) {
        return mysql_query($v);
    }

    //开启数据库锁行
    function db_begin( $option , $val ) {
        switch ($option) {
            case 'end':
                //判断要动的数据库是否正确，如果是正确的，则提交，否则，回滚数据
                if ($val) {
                    $this->db_query("COMMIT");
//                        echo 'is ok';
                } else {
                    $this->db_query("ROLLBACK");
//                        echo 'is no';
                }
                $this->db_query("END");
                break;
            default :$this->db_query("BEGIN");
                break;
        }
    }

//简化sql语句涵数
//关闭数据库
    function db_closemysql( $link , $row ) {
        $this->db_begin('end' , $row);
        return mysql_close($link);
    }

    //功能类的集合  
    //创建数据表

    function db_maketable( $name , $zhiduan ) {
        $new_db = "CREATE TABLE $name($zhiduan) or die('操作失败'.mysql_error())";
        $this->db_query($new_db);
    }

    //获取全局唯一ID，在db_id表里记录一个值，并返回该id号
    function db_select_id( $linkTab , $type , $who , $zhusi ) {

        //写入数据库,并用 $return 记录操作成功与否的状态 来确定数据执行还是回滚？
        self::$return = $this->db_inset('db_id' , '' , "0,'$linkTab','$type','$who',now(),'$zhusi'") ? TRUE : FALSE;
        //提取刚生成的记录的自增 ID
        $result = mysql_fetch_array($this->db_query("SELECT last_insert_id()"));
        //创建成功，返回全局唯一id和pid
        return $new_id = array('id' => $result[0] , 'ok' => self::$return);
    }

    //写入数据
    function db_inset( $biao , $name = '' , $value = '' ) {
        //判断有没有字段值
        if (!$name) {
//                echo "INSERT INTO $biao VALUES ($value)";
            self::$return = $this->db_query("INSERT INTO $biao VALUES ($value)"); // or die('操作失败' . mysql_error());
        } else {
//                echo "INSERT INTO $biao ($name) VALUES ($value)";
            self::$return = $this->db_query("INSERT INTO $biao ($name) VALUES ($value)"); // or die('操作失败' . mysql_error());
        }
        return self::$return;
    }

    //功能类---读取相关表段里的信息信息
    function db_read( $biao , $type = '' , $value = '' , $val = '' , $list = FALSE ) {
        //如果没有输入要查询的值
        if (!$value) {
            //如果没有传入要查找的类型
            if (!$type) {
                //只传入了表，查表，返回表中所有的行数据；
//                    echo "SELECT * FROM $biao";
                $read_sql = $this->db_query("SELECT * FROM $biao") or die('操作失败' . mysql_error());
            } else {
                //在表中按传入的字段查找，返回的仅是字段列的所有数据据，例：$type 的值是user_name，则返回相应表中user_name字段的每一行的名字；
//                    echo "SELECT $type FROM $biao";
                $read_sql = $this->db_query("SELECT $type FROM $biao") or die('按类型查找失败' . mysql_error());
            }
        } elseif (!$type) {
            //在表中按字段的值查表，返回的是按字段值匹配的整行的数据；
//                 echo "SELECT * FROM $biao WHERE $value='$val'";
            $read_sql = $this->db_query("SELECT * FROM $biao WHERE $value='$val'") or die('按字段查找失败' . mysql_error());
        } else {
            //在参数匹配行数据，但只返回指定的字段数据，如$type仅指定了user_name,user_pid，则仅返回查找到的行中的user_name和user_pid的值；
//                echo "SELECT $type FROM $biao WHERE $value='$val'";
            $read_sql = $this->db_query("SELECT $type FROM $biao WHERE $value='$val'") or die('按类型和字段查找失败' . mysql_error());
        }
        if (!$list) {
            $row = mysql_fetch_array($read_sql);
            return $row;
        } else {
            return $read_sql;
        }
    }

    //根据给定条件$value修改$table中的$id字段的值
    function db_edit( $table , $value , $id ) {
        $edit = $this->db_query("UPDATE $table set $value WHERE $id"); // or die(mysql_error());
        return $edit;
    }

    //删除数据
    function db_del_info( $table , $id ) {
        $sql = "DELETE FROM $table WHERE $id";
        $this->db_query($sql) or die('删除失败' . mysql_error());
        echo '删除成功';
    }

    //改变数据状态时，复制到另一张表，并删除原表中的数据
    function db_prod_shenhe( $id , $zhuantai ) {
        //改变商品状态值
        $this->db_edit(in_prod , "prod_state='$zhuantai'" , $id);
        //判断审核通过否，如果通过，就将相应的数据剪切到通过表，如果不通过，就将相应的数据剪切到不通过的表
        switch ($zhuantai) {
            case "通过":
                $this->db_query("INSERT INTO yes_prod SELECT * FROM in_prod WHERE $id") or die(mysql_error());
                $this->db_query("INSERT INTO all_prod SELECT * FROM in_prod WHERE $id") or die(mysql_error());
                $this->db_del_info(in_prod , $id);
                break;
            case "不通过":
                $this->db_query("INSERT INTO no_prod SELECT * FROM in_prod WHERE $id") or die(mysql_error());
                $this->db_query("INSERT INTO all_prod SELECT * FROM in_prod WHERE $id") or die(mysql_error());
                $this->db_db_del_info(in_prod , $id);
                break;
        }
    }

}

//涵数结束
?>