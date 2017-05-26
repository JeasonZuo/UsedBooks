<?php 
	define('ACCESS',true);
	require('./include/init.php');

	$books_id = isset($_GET['books_id'])?$_GET['books_id']+0:0;

	//查询商品信息
	$booksModel = new BooksModel();
	$booksInfo = $booksModel->find($books_id);
	if (empty($booksInfo)) {
		header('location: index.php');
	}

	////面包屑导航
	$cateModel = new CateModel();
	$parId = $cateModel->getParentsId($booksInfo['cat_id']);
	array_unshift($parId, $booksInfo['cat_id']);
	$parInfo = array();
	foreach ($parId as $value) {
		if($value != 0){
			array_unshift($parInfo, $cateModel->find($value));
		}
	}

	include(ROOT . 'view/front/shangpin.html');
?>