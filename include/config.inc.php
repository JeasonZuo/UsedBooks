<?php 
   header("Content-Type: text/html; charset=utf-8");
   defined('ACCESS') || exit('ACCESS Denied');
   /*
	file config.inc.php
	作用:配置文件
   */

	$_CFG = array(
		   'host' => 'localhost',
   		'user' => 'root',
   		'password' => '123456',
   		'db' => 'usedbooks',
   		'charset' => 'utf8'
	);

?>