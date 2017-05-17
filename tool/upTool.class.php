<?php 
	header("Content-Type: text/html; charset=utf-8");
	/*
	file:upTool.php
	作用:文件上传类
	*/
	defined('ACCESS') || exit('ACCESS Denied');

	
	class UpTool{
		protected $allow_ext = 'jpg,jpeg,gif,bmp,png';
		protected $maxSize = 1;	//M
		protected $errorNO = 0;	//错误代码
		protected $error = array(
				0 => '没有错误',
				1 => '文件大小超过php.ini上传文件大小限制',
				2 => '文件大小超过html表单MAX_FILE_SIZE',
				3 => '文件只有部分被上传',
				4 => '没有文件被上传',
				6 => '找不到临时文件',
				7 => '文件写入失败',
				8 => '不允许的文件后缀',
				9 => '文件大小超出类的允许范围',
				10 => '创建目录失败',
				11 => '移动文件失败',
				12 => '键不存在'

			);

		//设置$allow_ext
		public function setExt($ext){
			$this->allow_ext = $ext;
		}
		//设置$maxSize
		public function setSize($size){
			$this->maxSize = $size;
		}
		/**
		*作用:上传图片并检测错误
		*@param Srting $key 
		*@return String $dir 上传的文件保存在服务器的路径
		**/
		public function upLoad($key){
			if(!isset($_FILES[$key])){
				$this->errorNO = 12;
				return false;
			}
			$file =$_FILES[$key];

			//检验上传是否成功
			if($file['error']){
				$this->errorNO = $file['error'];
				return false; 
			}

			//获取后缀
			$ext = $this->getExt($file['name']);
			//检查后缀是否合法
			if(! $this->isAllowExt($ext)){
				$this->errorNO = 8;
				return false;
			}
			//检测大小
			if (!$this->isAllowSize($file['size'])) {
				$this->errorNO = 9;
				return false;
			}
			//创建目录
			$dir = $this->mkDateDir();
			if($dir == false){
				$this->errorNo = 10;
				return false;
			}
			//生成随机文件名
			$randname = $this->randName() . '.' . $ext;

			$dir = $dir . '/' . $randname;
			
			//上传文件
			if(!move_uploaded_file($file['tmp_name'] , $dir)){
				$this->errorNO = 11;
				return false;
			}

			return str_replace(ROOT, '' , $dir);
		}

		//返回错误原因
		public function getError(){
			return $this->error[$this->errorNO];
		}

		/**
		*返回文件后缀
		*@param String $file
		*@return String $ext 文件后缀
		**/
		protected function getExt($file){
			$tmp = explode('.', $file);
			return end($tmp);  
		}

		/**
		*判断文件后缀是否合法
		*@param String $ext 文件后缀
		*@return bool
		**/
		protected function isAllowExt($ext){
			return in_array(strtolower($ext) , explode(',' , strtolower($this->allow_ext)));    //字符串全部转为小写
		}

		/**
		*判断文件大小
		*@param int $size 文件大小
		*@return bool
		**/
		protected function isAllowSize($size){
			return $size <= $this->maxSize*1024*1024;
		}

		/**
		*按日期创建目录
		*@return String $dir
		**/
		protected function mkDateDir(){
			$dir = ROOT.'data/images/'. date('Ymd');

			if(is_dir($dir) || mkdir($dir,0777,true)){
				return $dir;
			}else{
				return false;
			}
		}

		/**
		*生成随机文件名
		*@param int $length 设置的随机文件名的长度
		*@return String 
		**/
		protected function randName($length=6){
			$str = 'abcdefghigkmneopqrstuvwxyz123456789';
			return substr(str_shuffle($str) , 0 , $length); 
		}



	}
?>