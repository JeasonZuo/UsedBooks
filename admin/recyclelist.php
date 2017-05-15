<?php 
	/*
	recyclelist.php
	删除书籍列表
	*/
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');

	$booksModel = new BooksModel();

	//查询books里所有is_delete=1的数据
	$bookslist = $booksModel->selectBooks(1);
	

	include(ROOT . 'view/admin/templates/goodslist.html');
?>