<?php

	class error_App{

		private $num;
		private $text;

		function __construct($num){
			$this->num = $num;
			$this->text = self::getText($this->num);
		}


		public static function getText($num){

			switch ($num) {
				case '1':
					$err = '非法的控制器，请检查网址是否正确';
					return $err;
					
				case '2':
					$err = '数据传参不正确';
					return $err;
				
				case '3':
					$err = '数据库连接错误';
					return $err;
                                    case '4':
                                        $err = '用户不存在,请核对用户名';
                                        return $err;

				default:
					$err = '您请求的页面未找到，404';
					return $err;
			}

		}

		function __destruct(){
			echo $this->text;
		}

	}