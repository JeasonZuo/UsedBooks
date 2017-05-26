<?php 
	/*
	购物流程界面(核心功能)
	*/
	define('ACCESS',true);
	require('./include/init.php');

	//设置动作参数act 判断用户行为
	if (isset($_GET['act'])) {
		$act = $_GET['act'];
	}else{
		$act = 'buy'; //默认为 buy
	}

	//购物车实例
	$cart = CartTool::getCart();
	$booksModel = new BooksModel();

	//购买
	if ($act == 'buy') {	//===========================购物车接界面======================
		$books_id = isset($_GET['books_id']) ? $_GET['books_id']+0 :  0;
		$num = isset($_GET['num']) ? $_GET['num']+0 : 1;
		//把商品放入购物车
		if ($books_id) {
			//取出书籍信息
			$b = $booksModel->find($books_id);
			if (!empty($b)) {
				//判断该商品是不是在回收站/下架
				if ($b['is_delete'] == 1 || $b['is_on_sale'] == 0) {
					$msg = '此商品不能购买';
					include(ROOT . 'view/front/showmsg.html');
					exit;
				}

				//把商品加入购物车
				$cart->addItem($books_id, $b['books_name'], $b['shop_price'], $b['market_price'], $b['thumb_img'], $num);
				
				//判断库存够不够
				$items = $cart->all();

				if ($items[$books_id]['num'] > $b['books_number']) {
					$cart->decNum($books_id,$num);
					$msg = '库存不足';
					include(ROOT . 'view/front/showmsg.html');
					exit;
				}
			}
		}


		if (empty($items)) {
			header('location:index.php');
			exit;
		}
		
		//总价
		$totalShop = $cart->getShopPrice();
		$totalMarket = $cart->getMarketPrice();
		$discount = $totalMarket - $totalShop;
		//print_r($items);
		include(ROOT . './view/front/jiesuan.html');

	} elseif($act == 'clear'){
		$cart->clear();
		$msg = '购物车已清空';
		include(ROOT . 'view/front/showmsg.html');

	} elseif($act == 'tijiao'){	//===================填写信息界面=====================
		$items = $cart->all();
		
		//总价
		$totalShop = $cart->getShopPrice();
		$totalMarket = $cart->getMarketPrice();
		$discount = $totalMarket - $totalShop;
		include(ROOT . 'view/front/tijiao.html');

	} elseif($act == 'done') {	//=========================提交订单完成界面=======================
		//print_r($_POST);
		$data['zone'] = $_POST['zone'];
		$data['reciver'] = $_POST['reciver'];
		$data['email'] = $_POST['email'];
		$data['address'] = $_POST['address'];
		$data['zipcode'] = $_POST['zipcode'];
		$data['tel'] = $_POST['tel'];
		$data['mobile'] = $_POST['mobile'];
		$data['building'] = $_POST['building'];
		$data['best_time'] = $_POST['best_time'];
		$data['add_time'] = time();
		$data['pay'] = $_POST['pay'];

		//检查不能为空的变量
		if (empty($data['zone'])) {
			$msg = "配送地区不能为空";
			include(ROOT . 'view/front/showmsg.html');
			exit;
		}
		if (empty($data['reciver'])) {
			$msg = "收货人姓名不能为空";
			include(ROOT . 'view/front/showmsg.html');
			exit;
		}
		if (empty($data['address'])) {
			$msg = "详细地址不能为空";
			include(ROOT . 'view/front/showmsg.html');
			exit;
		}
		if (empty($data['tel'])) {
			$msg = "电话不能为空";
			include(ROOT . 'view/front/showmsg.html');
			exit;
		}
		if (empty($data['pay'])) {
			$msg = "请选择支付方式";
			include(ROOT . 'view/front/showmsg.html');
			exit;
		}
		//检测Email的格式是否合法
		//filter_var(variable) 返回email或false
		if (filter_var($data['email'] , FILTER_VALIDATE_EMAIL) == false) {
			$msg = 'email格式不合法';
			include(ROOT . 'view/front/showmsg.html');
			exit;
		}

		//写入总金额
		$data['order_amount'] = $cart->getShopPrice();

		//用户id和用户名
		$data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id']+0 : 0;
		$data['username'] = isset($_SESSION['username']) ? $_SESSION['username'] : '';

		$orderInfoModel = new OrderInfoModel();

		//订单SN号
		$order_sn = $data['order_sn'] = $orderInfoModel->orderSn();

		if(!$orderInfoModel->add($data)){
			$msg = '写入订单失败';
			include(ROOT . 'view/front/showmsg.html');
			exit;

		}
		//echo "写入订单成功";

		//获取订单编号
		$order_id = $orderInfoModel->lastId();

		//订单对应的商品写入数据库
		$items = $cart->all();

		$orderbooksModel = new OrderBooksModel();
		//$count 计已经成功插入的订单
		$count = 0;

		foreach ($items as $key => $value) {
			$data = array();
			$data['order_id'] = $order_id;
			$data['order_sn'] = $order_sn;
			$data['books_id'] = $key;
			$data['books_number'] = $value['num'];
			$data['books_name'] = $value['name'];
			$data['shop_price'] = $value['shop_price'];
			$data['subtotal'] = $value['shop_price'] * $value['num'];

			if($orderbooksModel->addOB($data)) {
				//插入一条商品,+1
				$count += 1;
			}
		}

		if ($count != count($items)) {
			//商品未全部插入, 撤销此订单
			$orderInfoModel->invoke($order_id);
			$msg = '下订单失败';
	        include(ROOT . 'view/front/showmsg.html');
	        exit;
		}

		//订单入库成功,移除购物车中的商品
		$cart->clear();

		include(ROOT . 'view/front/order.html');
	}

