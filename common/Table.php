<?php 
namespace common;

use think\Db;

class Table
{
	public $table;
	
	public function __construct($table)
	{
		$this -> table = Db::table($table);
	}
	
	/**
	 * 获取多条数据
	 * @param unknown $where
	 * @param unknown $field
	 */
	public function getList($where, $field){
		$list = $this -> table
		  	-> field($field)
		  	-> where($where)
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
	
}