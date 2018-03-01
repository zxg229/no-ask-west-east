<?php
namespace Api10\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class AreaController extends Controller
{
	/**
	 * 获取省份信息列表
	 */
	public function getProvince(){
		$provinceModel = M('Province');
		$provinceData = array(
			'enable' => 1
		);
		$provinceList = $provinceModel->field('id as province_id,name,alias,name_en')->where($provinceData)->order('name_en')->select();

		echoJsonData(C('RESULT_CODE_ARR')['OK'], $provinceList);
	}

	/**
	 * 根据省份id获取城市列表
	 */
	public function getCity($province_id=0){
	if($province_id == 0){
		echoJsonData(C('RESULT_CODE_ARR')['PARAM_ERROR'], null);
	}
	else{

		$cityModel = M('City');
		$cityData = array(
				'enable'=>1, 'province_id'=>$province_id
		);
		$cityList = $cityModel->field('id as city_id,name,alias,name_en')->where($cityData)->select();
		echoJsonData(C('RESULT_CODE_ARR')['OK'], $cityList);

	}
}





	

}