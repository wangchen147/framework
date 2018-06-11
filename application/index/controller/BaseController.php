<?php
namespace app\index\controller;

use think\Controller;

class BaseController extends Controller
{
	public $style;
	
	public function __construct(){
		parent::__construct();
		
		$this->style = 'default';
	}
}
