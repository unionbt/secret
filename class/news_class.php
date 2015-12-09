<?php

    //新闻部分的核心模块，主要负责更新上传新闻、发布新闻、删除新闻等

    class News_Model {

    	public $data;
    	private $conn;

    	public function __construct($act,$id){

    		//连接数据库
    		$this->conn = new db_union_mysql();

    		//判断  $act  的值来请求相应的动作；
    		//默认为空时的操作为按id号查询，否则执行相关的动作，如增加、删除或修改等
    		if(!$act){
    			$this->data = $this->read($id);
    		}else{
    			$this->data= $this->$act($data,$id);
    		}
    		$this->conn->db_closemysql($conn);
    	}

    	//根据新闻id，查询新闻数据，并提取出来
    	function read($id){
    		$sql_data = $this->conn->db_read('news','','nid',$id);
    		return $sql_data;
    	}


    	//写入新闻


    	//删除新闻


    	

    	//处理结果，并返回结果到控制器

    	//关闭数据库连接
        
    }
?>

