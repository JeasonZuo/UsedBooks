<?php 
	header("Content-Type: text/html; charset=utf-8");
   defined('ACCESS') || exit('ACCESS Denied');
	class Mysql extends DB{
         static private  $ins = NULL;
   		private $con = NULL;
         private $conf = array();

   		//构造函数
   		protected function __construct(){
   			$this->conn();
   		}

         //实现单例模式
         static public function getIns(){
            if(!(self::$ins instanceof self)){  //instanceof 判断其左边对象是否为其右边类的实例
               self::$ins = new self();
            }
            return self::$ins;
         }

   		/**
		    *连接数据库,从配置文件里读取配置信息
   		*/
   		public function conn(){
   			$conf = Conf::getIns();
   			$this->con = new mysqli($conf->host , $conf->user , $conf->password , $conf->db);
   			$this->query('set names '.$conf->charset);
   		}
   		/**
		    *发送query查询
   		*/	
   		public function query($sql){
   			Log::write($sql);
   			return $this->con->query($sql);
   		}
   		/**
		    *查询多行数据
		    *@param string $sql sql语句
		    *@return array
   		*/
   		public function getAll($sql){
   			$data = array();
   			$res = $this->query($sql);
   			while ($row = $res->fetch_assoc()) {
   				$data[] = $row;
   			}
   			return $data;
   		}
   		/**
		    *单行数据
		    *@param string $sql sql语句
		    *@return array
   		*/
   		public function getRow($sql){
   			$res = $this->query($sql);
   			$row = $res->fetch_assoc();
   			return $row;
   		}
   		/**
		    *查询单个数据 如count(*)
		    *@param string $sql sql语句
		    *@return mixed
   		*/
   		public function getOne($sql){
   			$res = $this->query($sql);
   			$row = $res->fetch_row()[0];
   			return $row;
   		}
   		/**
		    *自动创建sql并执行
		    *@param array $data 关联数组 键/值与表的列/值对应
		    *@param string $table 表名字
		    *@param string $act 动作/update/insert
		    *@param string $where 条件,用于update
		    *@return int 新插入行的主键值或影响行数
   		*/ 
   		public function execSql($table , $data , $act = 'insert' , $where = '0'){
   			if($act == 'insert'){
   				//insert into table (id,name,age) values ('2','zjx',23);
   				$sql =  'insert into '.$table.' (';
   				$sql.= implode(',',array_keys($data)).') ';
   				$sql.= 'values ('.'\''.implode("','", array_values($data)).'\')';
   			}else{
   				//update table set name='zjx',age='35' where id=1;
   				$sql = "update $table set  ";
   				foreach ($data as $key => $value) {
   					$sql .= $key."='".$value."',";
   				}
   				$sql = rtrim($sql,',');
   				$sql.= " where $where";
   			}
   			return $this->query($sql);
   		}
   		/**
		    * 返回上一条语句产生的主键值
   		*/
   		public function lastId(){
   			return $this->con->insert_id;
   		}
   		/**
		    * 返回上一条语句影响的行数
   		*/
   		public function affectRows(){
   			return $this->con->affected_rows;
   		}
   	}
?>