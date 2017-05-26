<?php 
	/*
	file:cartTool.class.php
	作用: 购物车类
	*/
	header("Content-Type: text/html; charset=utf-8");
	defined('ACCESS')||exit('Acc Deined');

	class CartTool {
		private static $ins = null;
		private $items = array();

		final protected function __construct() {
		}

		final protected function __clone() {
		}

    	// 获取实例
		protected static function getIns() {
			if(!(self::$ins instanceof self)) {
				self::$ins = new self();
			}
			return self::$ins;
		}


    	// 把购物车的单例对象放到session里
		public static function getCart() {
			if(!isset($_SESSION['cart']) || !($_SESSION['cart'] instanceof self)) {
				$_SESSION['cart'] = self::getIns();
			}
			return $_SESSION['cart'];
		}


    /**
    *添加商品
    *@param int $id 商品主键
    *@param string $name 商品名称
    *@param float $shop_price 本店价格
    *@param float $market_price 市场价格
    *@param string $thumb_img 商品缩略图图片地址
    *@param int $num 购物数量
    **/
    public function addItem($id,$name,$shop_price,$market_price,$thumb_img,$num=1) {

        if($this->hasItem($id)) { // 如果该商品已经存在,则直接加其数量
        	$this->incNum($id,$num);
        	return;
        }
        
        $item = array();
        $item['name'] = $name;
        $item['shop_price'] = $shop_price;
        $item['market_price'] = $market_price;
        $item['thumb_img'] = $thumb_img;
        $item['num'] = $num;

        $this->items[$id] = $item;
    }


	    /*
	    修改购物车中的商品数量
	    param int $id 商品主键
	    param int $num 某个商品修改后的数量,即直接把某商品的数量改为$num
	    */
	    public function modNum($id,$num=1) {
	    	if(!$this->hasItem($id)) {
	    		return false;
	    	}
	    	$this->items[$id]['num'] = $num;

	    }


	    /*
	    商品数量增加1
	    */
	    public function incNum($id,$num=1) {
	    	if($this->hasItem($id)) {
	    		$this->items[$id]['num'] += $num;
	    	}
	    }


	    /*
	    商品数量减少1
	    */
	    public function decNum($id,$num=1) {
	    	if($this->hasItem($id)) {
	    		$this->items[$id]['num'] -= $num;
	    	}

	        // 如果减少后,数量为0了,则把这个商品从购物车删掉
	    	if($this->items[$id]['num'] < 1) {
	    		$this->delItem($id);
	    	}
	    }


	    /*
	        判断某商品是否存在
	    */
	        public function hasItem($id) {
	        	return array_key_exists($id,$this->items);
	        }


	    /*
	        删除商品
	    */
	        public function delItem($id) {
	        	unset($this->items[$id]);
	        }


	    /*
	        查询购物车中商品的种类
	    */
	        public function getCnt() {
	        	return count($this->items);
	        }


	    /*
	        查询购物车中商品的个数
	    */
	        public function getNum() {
	        	if($this->getCnt() == 0) {
	        		return 0;
	        	}
	        	$sum = 0;
	        	foreach($this->items as $item) {
	        		$sum += $item['num'];
	        	}
	        	return $sum;
	        }

	 /*
        查询购物车中商品的总金额
    */
        public function getShopPrice() {
        	if($this->getCnt() == 0) {
        		return 0;
        	}

        	$price = 0.0;

        	foreach($this->items as $item) {
        		$price += $item['num'] * $item['shop_price'];
        	}

        	return $price;
        }

     /*
        查询购物车中商品的总金额
    */
        public function getMarketPrice() {
        	if($this->getCnt() == 0) {
        		return 0;
        	}

        	$price = 0.0;

        	foreach($this->items as $item) {
        		$price += $item['num'] * $item['market_price'];
        	}

        	return $price;
        }




    /*
    返回购物车中的所有商品
    */

    public function all() {
    	return $this->items;
    }

    /*
        清空购物车
    */
        public function clear() {
        	$this->items = array();
        }
    }

    ?>