<?php 
	header("Content-Type: text/html; charset=utf-8");

	class TypeModel extends Model{
		protected $table = 'type';

		public function add($data){
			return $this -> db -> execSql($this->table , $data , 'insert');
		}
	}
?>