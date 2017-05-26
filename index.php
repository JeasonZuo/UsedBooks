<?php 
	define('ACCESS',true);
	require('./include/init.php');

	$booksModel = new BooksModel();
	$newlist = $booksModel->getNew();


	//工具书分类
	$toolbookslist = $booksModel->getCateBooks(24);

	include(ROOT . './view/front/index.html');
?>