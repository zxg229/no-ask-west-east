<?php
namespace Api10\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class TestController extends Controller
{

	public function index(){

		$skRootPath = 'SnailKids/Public/Upload/Trailer/Thumb/';
		$config = array(
				'maxSize'    =>    1048576,
				'rootPath'   =>    './'.$skRootPath,
				'savePath'   =>    '',
				'saveName'   =>    time().'_'.mt_rand(10,99),
				'exts'       =>    array('jpg', 'png', 'jpeg', 'bmp', 'mp4'),
				'autoSub'    =>    true,
				'subName'    =>    array('date','Ym')
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		$uploadInfo = $upload->uploadOne($_FILES['aaa']); //上传
		if(!$uploadInfo) {// 上传错误提示错误信息
			echo 0;
		}
		else{
			echo 1;
		}
	}

}