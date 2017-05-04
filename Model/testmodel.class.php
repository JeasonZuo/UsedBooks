<?php 
	//业务模型
	header("Content-Type: text/html; charset=utf-8");
	class TestModel extends Model{
		protected $table = 'test';
		/**
		*用户注册的方法
		*@param array $data
		*@return 
		**/
		public function register($data){
			return $this->db->execSql($this->table , $data , 'insert');
		}

		//获取信息
		public function select(){
			return $this -> db -> getAll('select * from '.$this -> table);
		}
	}
?>