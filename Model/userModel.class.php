<?php 
	header("Content-Type: text/html; charset=utf-8");
	defined('ACCESS')||exit('ACCESS Denied');

	class UserModel extends Model{
		protected $table = 'user';  //model控制的表
		protected $pkey  = 'user_id';  //主键

		//根据用户名查询用户是否存在
		public function checkUser($username , $password=''){
			if($password != ''){
				//查询用户名和密码是否符合
				$sql = 'select user_id,username,password from ' . $this->table . " where username='" . $username ."'";
				$row = $this->db->getRow($sql);
				if (empty($row)) {
					return false;
				}
				if($row['password'] !=md5($password)){
					return false;
				}
				unset($row['password']);
				return $row;
			}else{
				//查询用户是否存在
				$sql = 'select count(*) from ' . $this->table . " where username='" . $username ."'";
				return $this->db->getOne($sql);
			}
		}

		//注册 上传$data数据
		public function reg($data){
			if($data['password']){
				$data['password'] = md5($data['password']);
			}
			return $this->add($data);
		}

	}
?>