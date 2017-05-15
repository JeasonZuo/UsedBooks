<?php 
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');

	$books_id = $_GET['books_id'];

	//通过传来的$_GET['act']判断要进行的操作
	if ($_GET['act'] == 'delete') {
		$num = 1;
	}elseif($_GET['act'] == 'reduction'){
		$num = 0;
	}elseif($_GET['act'] == 'destory'){
		$num = 2;
	}

	$booksModel = new BooksModel();
	if($booksModel->recycle($books_id , $num)){
		echo '成功';
	}else{
		echo '失败';
	}
?>