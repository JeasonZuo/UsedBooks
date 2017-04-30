<?php 
	header("Content-Type: text/html; charset=utf-8");

	//递归转义数组
	function _addslashes($arr){
		foreach ($arr as $key => $value) {
			if(is_string($value)){
				$arr[$key] = addcslashes($value,'\",\'');
			}elseif(is_array($value)){
				$arr[$key] =  _addslashes($arr[$key]);
			}
		}
		return $arr;
	}
?>