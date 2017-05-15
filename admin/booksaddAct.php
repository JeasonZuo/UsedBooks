<?php 
	/*
	booksaddAct.php
	书籍上传
	*/
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');
    //require('../tool/upTool.class.php');

	//接收数据
	//print_r($_POST);

    $data = array();

    //数据检验
    $data['books_name'] = trim($_POST['goods_name']);
    if(empty($data['books_name'])){
    	echo '书籍名称不能为空';
    	exit;
    }

    
    $data['books_sn'] = trim($_POST['goods_sn']);			//书籍编码
    $data['writer'] = trim($_POST['writer']);				//作者
    $data['books_press'] = trim($_POST['books_press']);		//出版社
    $data['publish_time'] = trim($_POST['publish_time']);		//出版时间
    $data['cat_id'] = $_POST['cat_id'] + 0;				//栏目 cat_id
    $data['shop_price'] = $_POST['shop_price'] + 0;			//二手书售价
    $data['market_price'] = $_POST['market_price'] + 0;		//新书市场价
    $data['books_desc'] = $_POST['goods_desc'];				//书籍详细信息
    $data['books_weight'] = $_POST['goods_weight'] * $_POST['weight_unit'];	//书籍重量(kg)
    $data['books_number'] = $_POST['goods_number'] + 0;		//书籍库存
    $data['is_on_sale'] = isset($_POST['is_on_sale'])?1:0;		//是否出售
    $data['books_brief'] = $_POST['goods_brief'];    		//书籍简介
    $data['books_id'] = $_POST['goods_id'] + 0;   			//book id
    $data['add_time'] = time();   							//添加时间

    //上传图片
    $upTool = new UpTool();
    if($ori_img = ($upTool->upLoad('ori_img'))){
        $data['ori_img'] = $ori_img;
    }else{
        return $upTool->getError();
    }


    //print_r($data);

    $booksModel = new booksModel();

    if ($books_id = $booksModel->add($data)) {
    	echo '发布成功';
    }else{
    	echo '发布失败';
    }
?>