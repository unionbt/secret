<?php

    //新闻模块的控制器
    class News_App {
        
        private $id; //新闻id
        public $data;
        private $temp;



    	function __construct($val){

                if(!$val){
                    echo '新闻列表页';
                }  else {
                    $this->id   = explode('.',$val[0])[0];
    		$this->getNews($this->id);
                }
    		
    	}


    	private function getNews($id){

            $this->data = new News_Model(null,$id);

    	}

        function news_view(){
            $data       = $this->data;
            include ROOT.DS.VIEW.DS.'news.php';
        }

        function addNews(){
            
        }

    }