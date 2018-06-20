<?php
namespace app\index\controller;

use app\common\model\IndexModel;

class Index extends BaseController
{
    public function index()
    {
    	return view($this->style . "/Index/index");
    }
    
    public function test(){
    	$index_model = new IndexModel();
    	$index_model -> test();
    }
}
