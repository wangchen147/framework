<?php 
namespace common;

use think\Db;

class Table
{
	public $table;
	public $table_name;
	
	public function __construct($table)
	{
		$this -> table = Db::table($table);
		$this -> table_name = $table;
	}
	
	/**
	 * 获取多条数据
	 * @param unknown $where
	 * @param unknown $field
	 */
	public function getList($where, $field, $order){
		$list = $this -> table
		  	-> field($field)
		  	-> where($where)
		  	-> order($order)
		  	-> select();
		return $list;
	}
	
	/**
	 * 获取分页列表
	 * @param unknown $page
	 * @param unknown $page_size
	 * @param unknown $where
	 * @param unknown $field
	 * @param unknown $order
	 * @return unknown
	 */
	function getPageList($page, $page_size, $where, $field, $order){
		$list = $this -> table
			-> field($field)
		  	-> where($where)
		  	-> order($order)
		  	-> page($page, $page_size)
		  	-> select();
		return $list;
	}
	
	/**
	 * 获取单条数据
	 * @param unknown $where
	 * @param unknown $field
	 */
	public function getInfo($where, $field){
		$result = $this -> table
			-> field($field)
			-> where($where)
			-> find();
		return $result;
	}
	
	/**
	 * 添加与修改单条数据
	 * @param unknown $data
	 * @param unknown $where
	 */
	public function save($data = [], $where = []){
		// 添加数据
		if(empty($where)){
			// 成功返回1 考虑到会有没有主键的表 所以不返回最后一条自增id
			$result = $this->table
				-> insert($data);
			return $result;
		}else{
			// 返回受影响条数
			$result = $this->table
				-> where($where)
				-> update($data);
			return $result;
		}
	}
	
	/**
	 * 获取总数
	 * @param unknown $where
	 */
	public function getCount($where, $field = ""){
		var_dump($this->getTablePrimaryKey());
		if(empty($field)){
			$fields = $this->getTableFields();
			$field = $fields[0];
		}
		$count = $this -> table
			-> where($where)
			-> count($field);
		return $count;
	}
	
	/**
	 * 开启数据库事务
	 */
	public function startTrans(){
		Db::startTrans();
	}
	
	/**
	 * 提交事务
	 */
	public function commit(){
		Db::commit();
	}
	
	/**
	 * 回滚事务
	 */
	public function rollback(){
		Db::rollback();
	}
	
	/**
	 * 获取当前表的所有字段
	 */
	public function getTableFields(){
		$fields = Db::getTableInfo($this -> table_name, 'fields');
		return $fields;
	}
	
	/**
	 * 获取当前表主键
	 * return 有则返回主键 无则返回null
	 */
	public function getTablePrimaryKey(){
		$pk = Db::getTableInfo($this -> table_name, 'pk');
		return $pk;
	}
	
}