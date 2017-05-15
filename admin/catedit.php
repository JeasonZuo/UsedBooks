<?php 
	header("Content-Type: text/html; charset=utf-8");
	//栏目编辑页面
	define('ACCESS', true);
	require('../include/init.php');

	//保证$cat_id是一个有效的数字
	$cat_id = $_GET['cat_id'] + 0;

	$cateModel = new CateModel();
	$cateinfo = $cateModel->find($cat_id);
	$catelist = $cateModel->select();
	$catelist = $cateModel->getCateTree($catelist , 0);

	include(ROOT . 'view/admin/templates/catedit.html');
?>