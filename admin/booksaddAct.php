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

    if($ori_img){
        //处理图片 300*400 160*220
        $imageTool = new ImageTool();
        $ori_img = ROOT . $ori_img;
        //中等图地址 
        $books_img =  dirname($ori_img) . '/books_' . basename($ori_img);
        //缩略图地址
        $thumb_img =  dirname($ori_img) . '/thumb_' . basename($ori_img);

        if($imageTool->thumb($ori_img , $books_img , 300, 400)){
            $data['books_img'] = str_replace(ROOT , '' ,$books_img);
        }

        if($imageTool->thumb($ori_img , $thumb_img , 160, 220)){
            $data['thumb_img'] = str_replace(ROOT , '', $thumb_img);
        }    
    }





    //print_r($data);

    $booksModel = new booksModel();

    //自动添加商品货号
    if (empty($data['books_sn'])) {
        $data['books_sn'] = $booksModel->createSn();
    }

    if ($books_id = $booksModel->add($data)) {
    	echo '发布成功';
    }else{
    	echo '发布失败';
    }
?>