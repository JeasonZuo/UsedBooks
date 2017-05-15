<?php 
	header("Content-Type: text/html; charset=utf-8");
	defined('ACCESS')||exit('ACCESS Denied');

	class BooksModel extends Model{
		protected $table = 'books';
		protected $pkey = 'books_id';

		/**
		*作用:把商品放到回收站,还原,彻底删除
		*@param int $id
		*@param int $num 0不删除 1回收站 2彻底删除
		*@return bool
		**/
		public function recycle($id , $num){
			return $this->update(array('is_delete'=> $num ) , $id);
		}

		/**
		*作用:查所有删除或没被删除的书籍
		*@return array 
		**/
		public function selectBooks($is_delete){
			$sql = 'select * from ' . $this->table . ' where is_delete = '.$is_delete;
			return $this->db->getAll($sql);
		}
	}
?>