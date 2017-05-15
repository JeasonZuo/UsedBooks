<?php 
	/*
	catelist.php
	栏目列表
	*/
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');
	
	//调用model
	$cateModel = new CateModel();
	$catelist = $cateModel->select();
	$catelist = $cateModel->getCateTree($catelist , 0);

	include(ROOT . 'view/admin/templates/catelist.html');
?>