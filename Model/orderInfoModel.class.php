<?php 
	header("Content-Type: text/html; charset=utf-8");
	defined('ACCESS')||exit('ACCESS Denied');

	class OrderInfoModel extends Model {
		protected $table = 'orderinfo';  //model控制的表
		protected $pkey  = 'order_id';  //主键

		//生成随机的订单索引
		public function orderSn() {
	        $sn = 'or' . date('Ymd') . mt_rand(10000,99999);
	        $sql = 'select count(*) from ' . $this->table  . ' where order_sn=' . "'$sn'";
	        return $this->db->getOne($sql) ? $this->orderSn() : $sn;
    	}

    	//删除插入失败的订单
    	public function invoke($order_id) {
	        $this->delete($order_id); // 先删掉订单
	        $sql = 'delete from ordergoods where order_id = ' . $order_id; // 再删订单对应的商品
	        return $this->db->query($sql);
	    }
	}
?>