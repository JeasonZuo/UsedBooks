<?php 
	//业务模型
	header("Content-Type: text/html; charset=utf-8");
	defined('ACCESS') || exit('ACCESS Denied');
	class Model{
		protected $table = NULL;  //model控制的表
		protected $db = NULL;    //引入的mysql类对象
		protected $pkey  = NULL;  //主键
		//protected $fields = array();  //域

		public function __construct(){
			$this->db = Mysql::getIns();
		}

		//设置表
		public function table($table){
			$this -> table = $table;
		}

		

		/**
		*作用:插入数据
		*@param array $data
		*@return boolean
		**/
		public function add($data){
			return $this->db->execSql($this->table , $data);
		}

		/**
		*作用:删除数据
		*@param int $id 主键
		*@return int 影响的行数
		**/
		public function delete($cat_id = 0){
			$sql = 'delete from '.$this->table.' where ' . $this->pkey . '=' .$cat_id;
			if($this->db->query($sql)){
				return $this->db->affectRows();   //返回影响行数
			}else{
				return false;   //sql语句没执行成功
			}		
		}

		/**
		*作用:修改数据
		*@param int $id 主键
		*@param array $data
		*@return int 影响的行数
		**/
		public function update($data , $id){
			$rs =  $this->db->execSql($this->table , $data , 'update' , $this->pkey.'='. $id);
			if($rs){
				return $this->db->affectRows();   //返回影响行数
			}else{
				return false;   //sql语句没执行成功
			}	
		}

		/**
		*作用:查所有数据
		*@return array 
		**/
		public function select(){
			$sql = 'select * from ' . $this->table;
			return $this->db->getAll($sql);
		}

		/**
		*作用:查一行数据
		*@param int $id
		*@return array 
		**/
		public function find($id){
			$sql = 'select * from '.$this->table.' where ' .$this->pkey .'='. $id;
			return $this->db->getRow($sql);
		}

		/**
		*作用:返回刚插入数据的主键值
		*@return int $id  
		**/
		public function lastId() {
			return $this->db->lastId();
		} 

	}
?>