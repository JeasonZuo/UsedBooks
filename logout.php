<?php 
	define('ACCESS',true);
	require('./include/init.php');

	session_destroy();
	
	$msg = '退出成功';
	include(ROOT . './view/front/showmsg.html');
?>