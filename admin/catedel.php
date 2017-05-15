<?php 
	header("Content-Type: text/html; charset=utf-8");
	//栏目删除页面
	define('ACCESS', true);
	require('../include/init.php');

	$cat_id  = $_GET['cat_id'] + 0;

	$cateModel = new CateModel();


	//判断该栏目是否有子栏目
	$sons = $cateModel->getSons($cat_id);
	if(!empty($sons)){
		exit('有子栏目,不允许删除');
	}

	if($cateModel->delete($cat_id)){
		echo '删除成功';
	}else{
		echo '删除失败';
	}
?>