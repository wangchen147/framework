<?php 
namespace app\common\model;

use app\common\model\BaseModel;

class IndexModel extends BaseModel{
	
	public function test(){
		$table = new Table("user");
		var_dump($table -> getInfo("", "*"));
	}
}