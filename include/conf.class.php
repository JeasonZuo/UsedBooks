<?php 
   header("Content-Type: text/html; charset=utf-8");
   defined('ACCESS') || exit('ACCESS Denied');
   /*
	file conf.class.php
	作用:配置文件读写类
	单例模式
   */

	class Conf{
		protected static $ins = null;
		protected $data = array();

		final protected function __construct(){			
			//一次性把配置文件信息,读过来,赋给data属性,以后就不再管配置文件了,要载配置值时直接从data属性找
			include(ROOT.'include/config.inc.php');
			$this->data = $_CFG;
		}
		// 防止__construct被改写
		final protected function __clone(){
		}

		public static function getIns(){
			if(self::$ins instanceof self){  //判断$ins是否是Conf类的实例
				return self::$ins;
			}else{
				self::$ins = new self();
				return self::$ins;
			}
		}


		//用魔方法读取data内的信息
		public function __get($key){
			if(array_key_exists($key, $this->data)){
				return $this->data[$key];
			}else{
				return null;
			}
		}

		//用魔术方法,在运行期.动态增加或改变配置选项
		public function __set($key,$value){
			$this->data[$key] = $value;
		}
	}

/*	
	$conf = Conf::getIns();
	//读取选项
	echo $conf->host;
	
	//动态追加选项
	$conf->template_dir = "D:/what";
	echo $conf->template_dir;
*/
?>