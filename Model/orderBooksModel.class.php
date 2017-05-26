<?php 
	header("Content-Type: text/html; charset=utf-8");
	defined('ACCESS')||exit('ACCESS Denied');

	class OrderbooksModel extends Model{
		protected $table = 'orderbooks';
		protected $pK = 'ob_id';

		public function addOB($data){
			if ($this->add($data)) {
				$sql = 'update books set books_number = books_number - ' . $data['books_number'] . ' where books_id = ' . $data['books_id'];
				//商品数量减去用户购买的数量
				return $this->db->query($sql);
			}
			return false;
		}
	}
?>