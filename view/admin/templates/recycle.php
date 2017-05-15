<?php 
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS', true);
	require('../include/init.php');

	$id = $_GET['books_id'];

	$booksModel = new BooksModel();
	if($booksModel->modify($id)){
		echo '删除成功';
	}else{
		echo '移除失败';
	}
?>