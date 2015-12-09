<?php

	//这是一个网址分析的核心模块


	class path{

		public $uri;

		//获取网址传参
		function set_path(){
			
			//获取网址
			$url=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

			//分割网址
			$this->uri = explode(DS, $url);
			//删除每一个默认的空白值
			array_shift($this->uri);
			
			//将最后一个.html等后缀删除
			$this->uri[count($this->uri)-1] = explode('.',$this->uri[count($this->uri)-1])[0];

			//返回网址
			return $this->uri;

		}


		//生成网址
		function make_path($value){

			



		}





	}