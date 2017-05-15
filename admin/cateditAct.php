<?php 
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');

	//接收检验数据
	$cat_id = $_POST['cat_id'];
	$data = array();
	if (empty($_POST['cat_name'])) {
		exit('栏目名称不能为空');
	}
	$data['cat_name'] = $_POST['cat_name'];
	$data['intro'] = $_POST['intro'];
	$data['parent_id'] = $_POST['parent_id'] + 0;

	//实例化model,并调用model的相关方法
	$cateModel = new CateModel();

	//一个栏目不能成为其子孙栏目的子栏目
	$arr = array();
	$arr = $cateModel->getParentsId($data['parent_id']);
	foreach ($arr as $value) {
		if ($value == $cat_id) {
			exit('该栏目不能修改为其子孙栏目的子栏目!');
		}
	}

	if($cateModel -> modify($data , $cat_id)){
		echo '栏目编辑成功';
		exit;
	}else{
		echo '栏目编辑失败';
		exit;
	}
?>