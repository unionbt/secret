<?php

	//这是一个网址分析的核心模块


	class path{

		public $uri;

		//获取网址传参
		function set_path(){
			
			//获取域名后的传参，一般格式为 控制器/参数/控制器/参数/控制器/参数1&参数2.html
                        //当参数中带 '&'字符时，说明有1个以上的参数
			$url=parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
                        
			//分割网址,并用数组保存
			$this->uri = explode(DS, $url);
                        
			//删除每一个默认的空白值
			array_shift($this->uri);
			
                        //将最后一个.html等后缀删除
			$this->uri[count($this->uri)-1] = explode('.',$this->uri[count($this->uri)-1])[0];
                        
                        //检查每一个动作是否带有多参数
                        foreach ($this->uri as $key => $value) {
                            $tmp = explode('&', $value);
                            if(count($tmp) > 1){
                                $this->uri[$key] = $tmp;
                            }   
                        }
			
			//返回参数
			return $this->uri;

		}


		//生成网址
		function make_path($value){

			



		}





	}