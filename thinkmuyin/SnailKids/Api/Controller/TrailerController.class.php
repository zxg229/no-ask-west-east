<?php
namespace Api\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class TrailerController extends Controller
{
	/**
	 * index方法：宣传片页接口
	 * @param int $id 传递的宣传片id
	 */
	public function index($trailerId = 0){

		if($trailerId == 0){
			echoJsonData(C('RESULT_CODE_ARR')['PARAM_ERROR'], null);
		}
		else{
			//定义输出数组
			$data = array();
			$trailer = M('Trailer');
			$conditionTrailer['enable'] = 1;
			$conditionTrailer['id'] = $trailerId;
			$result = $trailer->field('id,name,thumb_path,introduce,standard_video_path,high_video_path')->where($conditionTrailer)->limit(1)->find();
			if($result){
				$data['trailer_id'] = $trailerId;
				$data['name'] = html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8');
				$data['thumb_path'] = getCompleteAddress($result['thumb_path']);
				$data['introduce'] = html_entity_decode($result['introduce'], ENT_QUOTES, 'UTF-8');
				$data['standard_video_path'] = getCompleteAddress($result['standard_video_path']);
				$data['high_video_path'] = getCompleteAddress($result['high_video_path']);
				echoJsonData(C('RESULT_CODE_ARR')['OK'], $data);
			}
			else{
				echoJsonData(C('RESULT_CODE_ARR')['NODATA'], null);
			}
		}
	}



}