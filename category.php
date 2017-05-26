<?php 
	define('ACCESS',true);
	require('./include/init.php');

	$cat_id = isset($_GET['cat_id'])?$_GET['cat_id']+0:0;

	$cateModel = new CateModel();
	$category = $cateModel->find($cat_id);
	//如果查询的栏目不存在,跳到首页
	if (empty($category)) {
		header('location: index.php');
		exit;
	}

	//树状导航
	$cates = $cateModel->select();
	$sort = $cateModel->getCateTree($cates , 0 );
	//print_r($sort);

	//面包屑导航
	$parId = $cateModel->getParentsId($cat_id);
	array_unshift($parId, $cat_id);
	$parInfo = array();
	foreach ($parId as $value) {
		if($value != 0){
			array_unshift($parInfo, $cateModel->find($value));
		}
	}
	

	//取出栏目下的商品
	$booksModel = new BooksModel();
	$bookslist = $booksModel->getCateBooks($cat_id);

	include(ROOT . './view/front/lanmu.html');
?>