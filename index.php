<?php 
   header("Content-Type: text/html; charset=utf-8");
   /*
	所有由用户访问的页面
	都得先加载init.php
   */
	require('./include/init.php');

	/*	
	$conf = Conf::getIns();
	//读取选项
	echo $conf->host;
	
	//动态追加选项
	$conf->template_dir = "D:/what";
	echo $conf->template_dir;
	*/

	//Log::write($sql);  写如日志文件
?>