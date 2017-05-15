<?php 
	/*
	bookslist.php
	书籍列表
	*/
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');

	$booksModel = new BooksModel();

	//查询books里所有is_delete=0的数据
	$bookslist = $booksModel->selectBooks(0);
	

	include(ROOT . 'view/admin/templates/goodslist.html');
?>