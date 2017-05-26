<?php 
	header("Content-Type: text/html; charset=utf-8");
	define('ACCESS',true);
	require('./include/init.php');

	//print_r($_POST);

	//数据检验
	//用户名是为空
	$data['username']  = $_POST['username'];
	if (empty($data['username'])) {
		$msg = '用户名不能为空';
		include(ROOT . 'view/front/showmsg.html');
		exit;
	}
	//用户名长度
	$length = strlen($data['username']);
	if($length>16){
		$msg = '用户名不能大于16个字符';
		include(ROOT . 'view/front/showmsg.html');
		exit;
	}
	//email是否合法
	$data['email'] = $_POST['email'];
	//filter_var(variable) 返回email或false
	if (filter_var($data['email'] , FILTER_VALIDATE_EMAIL) == false) {
		$msg = 'email格式不合法';
		include(ROOT . 'view/front/showmsg.html');
		exit;
	}
	//密码是否相同
	if ($_POST['password'] == $_POST['repassword']) {
		$data['password'] = $_POST['password'];
	}else{
		$msg = '两次密码不同';
		include(ROOT . 'view/front/showmsg.html');
		exit;
	}
	//密码是否为空
	if (empty($data['password'])) {
		$msg = '密码不能为空';
		include(ROOT . 'view/front/showmsg.html');
		exit;
	}
	

	//添加注册时间
	$data['regtime'] = time();

	$userModel = new UserModel();
	//检测用户名是否已存在
	if($userModel->checkUser($data['username'])){
		$msg = '用户名已经存在';
		include(ROOT . 'view/front/showmsg.html');
		exit;
	}

	//上传用户信息
	if($userModel->reg($data)){
		$msg = "用户注册成功";
	}else{
		$msg =  "用户注册失败";
	}

	include(ROOT . 'view/front/showmsg.html');
?>