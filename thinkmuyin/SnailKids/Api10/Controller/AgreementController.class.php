<?php
namespace Api10\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class AgreementController extends Controller
{

	/**
	 * 协议页接口
	 * 显示webview
	 */
	public function index(){
		$this->assign('img', getCompleteAddress('SnailKids/Public/Image/agreement_icon.png'));
		$this->display();
	}

}