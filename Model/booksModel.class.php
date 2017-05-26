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
			$arr =  $this->db->getAll($sql);
			return $arr;
		}

		/**
		*创建商品货号
		**/
		public function createSn(){
			$sn = date('Ymd') . mt_rand(10000,99999);
			$sql = 'select count(*) from ' . $this->table . ' where books_sn=' . $sn;
			if($this->db->getOne($sql) == 0){
				return $sn;
			}else{
				$this->createSn();
			}
		}

		/*
		*取出指定条数的最新发布商品
		*/
		public function getNew($n = 5){
			$sql = 'select books_id,books_name,shop_price,market_price,thumb_img from '.$this->table.' order by add_time desc limit '.$n;
			//echo $sql;
			return $this->db->getAll($sql);
		}

		/*
		*取出指定栏目的商品
		*/
		public function getCateBooks($cat_id){
			$cateModel =  new CateModel();
			//取出所有栏目
			$arr = $cateModel->select();
			//取cat_id下所有子栏目
			$sons = $cateModel->getCateTree($arr,$cat_id);
			//将栏目和子栏目的$cat_id放到$sub_id里
			$sub_id = array($cat_id);
			if (!empty($sons)) {
				foreach ($sons as $value) {
					$sub_id[] = $value['cat_id'];
				}
			}

			$in = implode(',', $sub_id);

			$sql = 'select books_id,books_name,shop_price,market_price,thumb_img from '.$this->table.
			' where cat_id in ('.$in.')' ;

			return $this->db->getAll($sql);
		}


	}
?>