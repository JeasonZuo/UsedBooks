<?php 
   header("Content-Type: text/html; charset=utf-8");
   /*
	file init.php
	作用:框架初始化
   */
	//防止非法访问
	defined('ACCESS') || exit('ACCESS Denied');

	//日志记录功能

	//初始化当前的绝对路径
	//linux和win都支持正斜线,linux不支持反斜线
	define('ROOT',str_replace('\\', '/',dirname(dirname(__FILE__))).'/');
	//echo ROOT;exit;
	define('DEBUG', true);
	
	require(ROOT . 'include/lib_base.php');

	//__autoload  尝试加载未定义的类 
	//过定义这个函数来启用类的自动加载
	function __autoload($class){
		if(stripos($class , 'model') !== false){	//stripos   查找字符串首次出现的位置（不区分大小写） 
			require(ROOT . '/Model/' . $class . '.class.php');
		}elseif (stripos($class , 'tool') !== false) {
			require(ROOT . '/tool/' . $class . '.class.php');
		}else{
			require(ROOT . '/include/' . $class . '.class.php');
		}
	}


	//递归过滤参数,用递归的方式过滤$_GET,$_POST,$_COOKIE
	$_GET = _addslashes($_GET);
	$_POST = _addslashes($_POST);
	$_COOKIE = _addslashes($_COOKIE);

	//设置报错级别
	if(defined('DEBUG')){
		error_reporting(E_ALL);
	}else{
		error_reporting(0);
	}


?>