<?php
namespace Api10\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class ActiveController extends Controller
{

	/**
	 * 活动页接口
	 * 显示webview
	 */
	public function index(){

		$img = 'SnailKids/Public/Upload/Active/Image/active3.png';
		$this->assign('img',getCompleteAddress($img));
		$this->display();
	}

}