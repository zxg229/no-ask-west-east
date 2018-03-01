<?php
namespace Api\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class PackageController extends Controller
{
	/**
	 * index方法：套餐页接口
	 */
	public function index($packageId = 0){

		//查询全部可用的套餐 按ID升序排列
		$package = M('Package');
		$packageCondition['enable'] = 1;
		$packageList = $package->field('id,name')->where($packageCondition)->order('id')->select();

		if($packageList === false){
			echoJsonData(C('RESULT_CODE_ARR')['QUERY_ERROR'], null);
		}
		elseif($packageList == null){
			echoJsonData(C('RESULT_CODE_ARR')['NODATA'], null);
		}
		else{
			$data = array(
				'current_package_id' => '',
				'package_group' => array(),
				'current_package_data' => array()
			);

			$packageIds = array();
			foreach($packageList as $p){
				array_push($packageIds, $p['id']);
				$tmp = array(
					'package_id' => $p['id'],
					'package_name' => html_entity_decode($p['name'], ENT_QUOTES, 'UTF-8')
				);
				array_push($data['package_group'], $tmp);
			}

			//检测当前参数id是否在可用的套餐id数组中
			if(!in_array($packageId, $packageIds)){

				if($packageId == 0){ //如果传进来的参数id是0 则是默认访问 查找第一个套餐的内容
					$data['current_package_id'] = $packageIds[0];
				}
				else{ //如果既不是默认访问 且访问的id也不在可用的套餐id数组中 那么这次访问视为无效 返回无数据
					echoJsonData(C('RESULT_CODE_ARR')['NODATA'], null);
				}
			}
			else{ //
				$data['current_package_id'] = $packageId;
			}

			//查询特定套餐数据
			$packageCondition['enable'] = 1;
			$packageCondition['id'] = $data['current_package_id'];
			$packageRow = $package->where($packageCondition)->limit(1)->find();

			if($packageRow === false){
				echoJsonData(C('RESULT_CODE_ARR')['QUERY_ERROR'], null);
			}
			elseif($packageRow == null){
				echoJsonData(C('RESULT_CODE_ARR')['NODATA'], null);
			}
			else{
				$imagePathGroup = explode('|', $packageRow['image_path_group']);
				$imagePathGroup2 = array();
				foreach($imagePathGroup as $path){
					array_push($imagePathGroup2, getCompleteAddress($path));
				}
				$data['current_package_data'] = array(
					'name' => html_entity_decode($packageRow['name'], ENT_QUOTES, 'UTF-8'),
					'alias' => html_entity_decode($packageRow['alias'], ENT_QUOTES, 'UTF-8'),
					'price' => html_entity_decode($packageRow['price'], ENT_QUOTES, 'UTF-8'),
					'content' => html_entity_decode($packageRow['content'], ENT_QUOTES, 'UTF-8'),
					'describe' => html_entity_decode($packageRow['describe'], ENT_QUOTES, 'UTF-8'),
					'cover_path' => getCompleteAddress($packageRow['cover_path']),
					'image_path_group' => $imagePathGroup2
				);

				echoJsonData(C('RESULT_CODE_ARR')['OK'], $data);
			}
		}
	}


}