<?php 
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');

	//接收books_id
	$books_id = $_GET['books_id'] + 0;

	//实例化booksModel
	$booksModel = new BooksModel;
	
	//调用find方法
	$books = $booksModel->find($books_id);

	if(empty($books)){
		exit('商品不存在');
	}

	//展示商品信息
	print_r($books);
?>