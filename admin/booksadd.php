<?php 
	/*
	booksadd.php
	书籍添加界面
	*/
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');

	$cateModel = new CateModel();
	$catelist = $cateModel->select();
	$catelist = $cateModel->getCateTree($catelist , 0);

	include(ROOT . 'view/admin/templates/goodsadd.html');
?>