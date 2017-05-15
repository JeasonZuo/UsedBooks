<?php 
	header("Content-Type: text/html; charset=utf-8");
	defined('ACCESS')||exit('ACCESS Denied');

	class CateModel extends Model{
		protected $table = 'category';

		/**
		*将$_POST数据插入数据库
		*@param array $data
		*@return boolean
		**/
		public function add($data){
			return $this->db->execSql($this->table , $data);
		}

		/**
		*用$_POST数据update数据库
		*@param array
		*@return boolean
		**/
		public function modify($data , $cat_id){
			return $this->db->execSql($this->table , $data , 'update' , 'cat_id='.$cat_id);
		}

		//获取表下面的所有数据
		public function select(){
			$sql = 'select cat_id,cat_name,parent_id from '.$this->table;
			return $this->db->getAll($sql);
		}

		//取出一行数据
		public function find($cat_id){
			$sql = 'select cat_id,cat_name,intro,parent_id from '.$this->table.' where cat_id='.$cat_id;
			//echo $sql;
			return $this->db->getRow($sql);
		}

		/**
		*作用:获取栏目的子孙数
		*@param int $id
		*@return $id栏目的子孙树
		**/
		public function getCateTree($arr , $id=0 , $lev=0){
			$tree = array();
			foreach ($arr as $value) {
				if($value['parent_id'] == $id){
					$value['lev'] = $lev;
					$tree[] =  $value;
					$tree = array_merge($tree , $this->getCateTree($arr , $value['cat_id'] ,$lev+1));
				}
			}
			return $tree;
		}

		/**
		*作用:删除栏目
		*@param  int $cat_id
		*@return boolean
		**/
		public function delete($cat_id = 0){
			$sql = 'delete from '.$this->table.' where cat_id ='.$cat_id;
			$this->db->query($sql);

			return $this->db->affectRows();
		}

		/**
		*查询一个栏目下的子栏目
		*@param int $id
		*@return array $id栏目下的子栏目
		**/
		public function getSons($id){
			$sql = 'select cat_id,cat_name,parent_id from '.$this->table.' where parent_id ='.$id;
			return $this->db->getAll($sql);
		}

		/**
		*查询一个栏目的父栏目
		*@param int $id
		*@return array $id栏目父栏目id的数组
		**/
		public function getParentsId($id){
			static $arr = array();
			$sql = 'select parent_id from '.$this->table.' where cat_id='.$id;
			$parent_id = $this->db->getOne($sql) + 0;
			$arr[] = $parent_id;
			if($parent_id === 0){
				return $arr;
			}
			$this->getParentsId($parent_id);
			return $arr;
		}
	}
?>