<?php
namespace Api10\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class OpinionController extends Controller
{

	/**
	 * 意见反馈接收接口
	 * 接收post变量 user_id theme video address opinion connection
	 */
	public function submit(){

		$opinionDModel = D('Opinion');
		$opinionData = array(
			'user_id' => I('post.user_id'),
			'theme' => I('post.theme'),
			'video' => I('post.video'),
			'address' => I('post.address'),
			'opinion' => I('post.opinion'),
			'connection' => I('post.connection'),
			'add_time' => time()
		);
		if(!$opinionDModel->create($opinionData)){
			echoJsonData2('意见反馈信息有误：'.$opinionDModel->getError(),null);
			exit;
		}
		else{
			//插入数据库
			if($opinionDModel->add()){
				echoJsonData(C('RESULT_CODE_ARR')['OK'],null);
				exit;
			}
			else{
				echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'],null);
				exit;
			}
		}
	}

}