<?php 
namespace app\common\model;

use think\Db;

class Table
{
	public $table; // 表操作对象
	public $table_name; // 表名
	
	/**
	 * 构造函数
	 * @param unknown $table
	 * @param string $alias
	 * @param array $join
	 */
	public function __construct($table, $alias = "", $join = [])
	{
		$this -> table = db($table);
		$this -> table_name = $table;
		if(!empty($alias) && !empty($join)){
			$this -> setTableJoin($alias, $join);  
		}
	}
	
	/**
	 * 设置多表连接
	 * @param unknown $alias 当前数据表的别名
	 * @param unknown $join 其他数据表以及别名 二维数组
	 */
	public function setTableJoin($alias, $join){
		$this -> table = $this -> table
			-> alias($alias)
			-> join($join);
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
		$return_list = array();
		$return_list["list"] = $this -> table
			-> field($field)
		  	-> where($where)
		  	-> order($order)
		  	-> page($page, $page_size)
		  	-> select();
		$return_list["total_count"] = $this -> getCount($where, $field);
		$return_list["page_count"] = 1;
		if($return_list["total_count"] > 0 && $page_size > 0){
			$return_list["page_count"] = ceil(($return_list["total_count"] / $page_size));
		}
		return $return_list;
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
	 * @param array $data
	 * @param array $where
	 * @return unknown 返回受影响条数
	 */
	public function save($data = [], $where = []){
		// 添加数据
		if(empty($where)){
			// 成功返回1 考虑到会有没有主键的表 所以不返回最后一条自增id
			$result = $this -> table
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
	 * 保存多条数据
	 * @param unknown $data
	 * @return unknown 返回添加成功的条数
	 */
	public function saveAll($data){
		$result = $this -> table
			-> insertAll($data);
		return $result;
	}
	
	/**
	 * 获取某个字段的总数
	 * @param unknown $where
	 */
	public function getCount($where, $field){
		$count = $this -> table
			-> where($where)
			-> count($field);
		return $count;
	}
	
	/**
	 * 获取某个字段的最大值
	 * @param unknown $where
	 * @param unknown $field
	 */
	public function getMax($where, $field){
		$result = $this -> table
			-> where($where)
			-> max($field);
		return $result;
	}
	
	/**
	 * 获取某个字段的最小值
	 * @param unknown $where
	 * @param unknown $field
	 */
	public function getMin($where, $field){
		$result = $this -> table
			-> where($where)
			-> min($field);
		return $result;
	}
	
	/**
	 * 获取某个字段的总和
	 * @param unknown $where
	 * @param unknown $field
	 */
	public function getSum($where, $field){
		$result = $this -> table
			-> where($where)
			-> sum($field);
		return $result;
	}
	
	/**
	 * 获取某个字段的平均数
	 * @param unknown $where
	 * @param unknown $field
	 */
	public function getAvg($where, $field){
		$result = $this -> table
			-> where($where)
			-> avg($field);
		return $result;
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