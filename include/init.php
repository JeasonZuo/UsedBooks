<?php 
   header("Content-Type: text/html; charset=utf-8");
   /*
	file init.php
	作用:框架初始化
   */

	//递归过滤参数,用递归的方式过滤$_GET,$_POST,$_COOKIE

	//日志记录功能

	//初始化当前的绝对路径
	//linux和win都支持正斜线,linux不支持反斜线
	define('ROOT',str_replace('\\', '/',dirname(dirname(__FILE__))).'/');
	//echo ROOT;exit;
	define('DEBUG', true);
	
	require(ROOT . 'include/db.class.php');
	require(ROOT . 'include/conf.class.php');

	//设置报错级别
	if(defined('DEBUG')){
		error_reporting(E_ALL);
	}else{
		error_reporting(0);
	}


?>