<?php

    //新闻模块的控制器
    class News_App {
        
        private $id;		//新闻id
        public $data;
        private $temp;



    	function __construct($arr){

    		$this->id   = explode('.',$arr[0])[0];

    		$this->getNews($this->id);
    	}


    	private function getNews($id){

            $this->data = new News_Model(null,$id);

    	}

        function __destruct(){
            $data       = $this->data;
            include ROOT.DS.VIEW.DS.'news.php';
        }

        function addNews(){
            
        }

    }