<?php
namespace Api\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class OrderController extends Controller
{
	/**
	 * 向客户端展示列表项
	 */
	public function index(){

		$data = array(
			'phase_id' => array(),
			'theme_id' => array(),
			'duration' => array('9分钟','6分钟','3分钟','其他'),
			'writting' => '是否自撰稿',
			'makeup' => '是否带妆',
			'light' => '是否免灯',
			'prop' => '是否需要额外道具',
			'request' => '后期呈现效果是否有特殊要求'
		);

		$phase = M('phase');
		$phaseList = $phase->select();
		if($phaseList){
			foreach($phaseList as $p){
				$tmpP = array(
					'p_id' => $p['id'],
					'p_name' => $p['name']
				);
				array_push($data['phase_id'], $tmpP);
			}
		}

		$theme = M('Theme');
		$themeList = $theme->select();
		if($themeList){
			foreach($themeList as $t){
				$tmpT = array(
						't_id' => $t['id'],
						't_name' => $t['name']
				);
				array_push($data['theme_id'], $tmpT);
			}
			array_push($data['theme_id'], array('t_id'=>'0', 't_name'=>'其他主题'));
		}

		echoJsonData(C('RESULT_CODE_ARR')['OK'], $data);

	}

	/*
	 * 接收套餐预约
	 */
	public function packageOrder(){

		$now = time();

		$orderData = array();
		$orderData['realname'] = I('post.realname');
		$orderData['sex'] = I('post.sex');
		$orderData['phone'] = I('post.phone');
		$orderData['address'] = I('post.address');
		$orderData['address_detail'] = I('post.address_detail');
		$orderData['order_time'] = I('post.order_time');
		$orderData['note'] = I('post.note');
		$orderData['type'] = 1;
		$orderData['state'] = 1;
		$orderData['pay'] = 0;
		$orderData['link_id'] = I('post.link_id');;
		$orderData['add_time'] = $now;
		$orderData['edit_time'] = $now;
		$orderData['admin_id'] = 0;

		$order = D('Order');

		if(!$order->create($orderData)){
			//echoJsonData(array('code'=>'03','info'=>$order->getError()), null);
			echoJsonData(C('RESULT_CODE_ARR')['POST_ERROR'], null);
		}
		else{

			$orderResult = $order->add($orderData);
			if($orderResult){
				echoJsonData(C('RESULT_CODE_ARR')['OK'], null);
			}
			else{
				echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'], null);
			}
		}

	}

	/**
	 * 接收订制预约
	 */
	public function customOrder(){
		$now = time();

		$orderDetailData = array();
		$orderDetailData['phase_id'] = I('post.phase_id');
		$orderDetailData['theme_id'] = I('post.theme_id');
		$orderDetailData['duration'] = I('post.duration');
		$orderDetailData['writting'] = I('post.writting');
		$orderDetailData['makeup'] = I('post.makeup');
		$orderDetailData['light'] = I('post.light');
		$orderDetailData['prop'] = I('post.prop');
		$orderDetailData['request'] = I('post.request');

		$orderDetail = D('Orderdetail');

		if(!$orderDetail->create($orderDetailData)){
			echoJsonData(C('RESULT_CODE_ARR')['POST_ERROR'], null);
		}
		else{
			$orderData = array();
			$orderData['realname'] = I('post.realname');
			$orderData['sex'] = I('post.sex');
			$orderData['phone'] = I('post.phone');
			$orderData['address'] = I('post.address');
			$orderData['address_detail'] = I('post.address_detail');
			$orderData['order_time'] = I('post.order_time');
			$orderData['note'] = I('post.note');
			$orderData['type'] = 0;
			$orderData['state'] = 1;
			$orderData['pay'] = 0;
			$orderData['add_time'] = $now;
			$orderData['edit_time'] = $now;
			$orderData['admin_id'] = 0;

			$order = D('Order');

			if(!$order->create($orderData)){
				echoJsonData(C('RESULT_CODE_ARR')['POST_ERROR'], null);
			}
			else{
				//插入orderDetail
				$orderDetailResult = $orderDetail->add($orderDetailData);
				if($orderDetailResult){
					$linkId = $orderDetailResult;
					$orderData['link_id'] = $linkId;
					$orderResult = $order->add($orderData);
					if($orderResult){
						echoJsonData(C('RESULT_CODE_ARR')['OK'], null);
					}
					else{
						echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'], null);
					}
				}
				else{
					echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'], null);
				}
			}

		}
	}



	public function testOrder(){

		$phase = M('Phase');
		$phaseList = $phase->select();
		$this->assign('phaseList', $phaseList);

		$theme = M('Theme');
		$themeList = $theme->select();
		$this->assign('themeList', $themeList);


		$this->display();
	}

	public function testOrderDo(){

		$now = time();

		$orderDetailData = array();
		$orderDetailData['phase_id'] = I('post.phase_id');
		$orderDetailData['theme_id'] = I('post.theme_id');
		$orderDetailData['duration'] = I('post.duration');
		$orderDetailData['writting'] = I('post.writting');
		$orderDetailData['makeup'] = I('post.makeup');
		$orderDetailData['light'] = I('post.light');
		$orderDetailData['prop'] = I('post.prop');
		$orderDetailData['request'] = I('post.request');

		$orderDetail = D('Orderdetail');

		if(!$orderDetail->create($orderDetailData)){
			$this->error($orderDetail->getError());
		}
		else{
			$orderData = array();
			$orderData['realname'] = I('post.realname');
			$orderData['sex'] = I('post.sex');
			$orderData['phone'] = I('post.phone');
			$orderData['address'] = I('post.address');
			$orderData['address_detail'] = I('post.address_detail');
			$orderData['order_time'] = I('post.order_time');
			$orderData['note'] = I('post.note');
			$orderData['type'] = 0;
			$orderData['state'] = 1;
			$orderData['pay'] = 0;
			$orderData['add_time'] = $now;
			$orderData['edit_time'] = $now;
			$orderData['admin_id'] = 0;

			$order = D('Order');

			if(!$order->create($orderData)){
				$this->error($order->getError());
			}
			else{
				//插入orderDetail
				$orderDetailResult = $orderDetail->add($orderDetailData);
				if($orderDetailResult){
					$linkId = $orderDetailResult;
					$orderData['link_id'] = $linkId;
					$orderResult = $order->add($orderData);
					if($orderResult){
						echo 'ok';
					}
					else{
						$this->error($order->getError());
					}
				}
				else{
					$this->error($orderDetail->getError());
				}
			}

		}


	}

	public function testPackage(){

		$package = M('Package');
		$packageList = $package->where('enable=1')->select();
		$this->assign('packageList', $packageList);
		$this->display();
	}

	public function testPackageDo(){

		$now = time();

		$orderData = array();
		$orderData['realname'] = I('post.realname');
		$orderData['sex'] = I('post.sex');
		$orderData['phone'] = I('post.phone');
		$orderData['address'] = I('post.address');
		$orderData['address_detail'] = I('post.address_detail');
		$orderData['order_time'] = I('post.order_time');
		$orderData['note'] = I('post.note');
		$orderData['type'] = 1;
		$orderData['state'] = 1;
		$orderData['pay'] = 0;
		$orderData['link_id'] = I('post.link_id');;
		$orderData['add_time'] = $now;
		$orderData['edit_time'] = $now;
		$orderData['admin_id'] = 0;

		$order = D('Order');

		if(!$order->create($orderData)){
			$this->error($order->getError());
		}
		else{

			$orderResult = $order->add($orderData);
			if($orderResult){
				echo 'ok';
			}
			else{
				$this->error($order->getError());
			}
		}
	}


}