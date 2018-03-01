<?php
namespace Api\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class ActiveController extends Controller
{

	/**
	 * 协议页接口
	 * 显示webview
	 */
	public function index(){
		$this->display();
	}

}