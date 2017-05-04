<?php 
	//业务模型
	header("Content-Type: text/html; charset=utf-8");
	defined('ACCESS') || exit('ACCESS Denied');
	class Model{
		protected $table = NULL;  //model控制的表
		protected $db = NULL;    //引入的mysql类对象

		public function __construct(){
			$this->db = Mysql::getIns();
		}

		public function table($table){
			$this -> table = $table;
		}
	}
?>