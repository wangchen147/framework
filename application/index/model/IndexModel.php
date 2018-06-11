<?php 
namespace app\index\model;

use common\Table;
class IndexModel
{
	public function __construct()
	{
		
	}
	
	public function test()
	{
		$user = new Table("user");
		
		$data = array();
		$res = $user -> save($data, ["uid" => 3]);
		var_dump($res);
	}
}
