<?php 
	define('ACCESS',true);
	require('./include/init.php');


	if(isset($_POST['act'])){
		//点击了登录按钮
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		//合法性检测
		if(empty($username)){
			$msg = '用户名不能为空';
			include(ROOT . 'view/front/showmsg.html');
			exit;
		}
		if(empty($password)){
			$msg = '密码不能为空';
			include(ROOT . 'view/front/showmsg.html');
			exit;
		}
		
		//检验用户名密码
		$userModel = new userModel();
		$row = $userModel-> checkUser($username , $password);
		if(!$row){
			$msg = '用户名或密码错误';
		}else{
			$msg = '登录成功';
			$_SESSION = $row;

			//若勾选了记住用户名,设置cookie
			if (isset($_POST['remember']) && $_POST['remember'] == 1) {
				setcookie('remember' , $username , time()+10*24*60*60);
			}else{
				setcookie('remember' ,'', 0);
			}
		}
		include(ROOT . 'view/front/showmsg.html');
		exit;
	}else{
		//没点击登录按钮显示登录界面
		include(ROOT . './view/front/denglu.html');
	}

?>