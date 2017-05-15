<?php 
	/*
	file:cateaddAction.php
	作用:接收cateadd.php表单发送的数据
	并调用model,把数据入库
	*/
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');

	//接收数据
	//print_r($_POST);

	//检验数据
	$data = array();
	if (empty($_POST['cat_name'])) {
		exit('栏目名称不能为空');
	}
	$data['cat_name'] = $_POST['cat_name'];
	$data['intro'] = $_POST['intro'];
	$data['parent_id'] = $_POST['parent_id'];
	//print_r($data);exit;


	//实例化model,并调用model的相关方法
	$cateModel = new CateModel();
	if($cateModel -> add($data)){
		echo '栏目添加成功';
		exit;
	}else{
		echo '栏目添加失败';
		exit;
	}
?>