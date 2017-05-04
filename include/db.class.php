<?php 
   header("Content-Type: text/html; charset=utf-8");

   /*
	file db.class.php
	作用:数据库类
   */

	abstract class DB{
		/**
		*连接数据库,从配置文件里读取配置信息
   		*/
   		abstract public function conn();
   		/**
		*发送query查询
		*@param string $sql sql语句
		*@return mixed resource/bool
   		*/
   		abstract public function query($sql);
   		/**
		*查询多行数据
		*@param string $sql sql语句
		*@return array/bool
   		*/
   		abstract public function getAll($sql);
   		/**
		*单行数据
		*@param string $sql sql语句
		*@return array
   		*/
   		abstract public function getRow($sql);
   		/**
		*查询单个数据 如count(*)
		*@param string $sql sql语句
		*@return mixed
   		*/
   		abstract public function getOne($sql);
   		/**
		*自动创建sql并执行
		*@param array $data 关联数组 键/值与表的列/值对应
		*@param string $table 表名字
		*@param string $act 动作/update/insert
		*@param string $where 条件,用于update
		*@return int 新插入行的主键值或影响行数
   		*/ 
   		abstract public function execSql($table , $data , $act = 'insert' , $where = '0');
   		/**
		* 返回上一条语句产生的主键值
   		*/
   		abstract public function lastId();
   		/**
		* 返回上一条语句影响的行数
   		*/
   		abstract public function affectRows();
	}
?>