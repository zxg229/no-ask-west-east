<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class OrderController extends Controller
{
	/**
	 * index方法：显示订单列表
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function index($p = 1, $where = 'all', $order = 'id_desc'){

		$ordershoot = M('Order');

		//定义筛选规则数组
		$wheres = array(
			'all' 	    => array('tag'=>'全部订单', 'where'=>''),
			'type0'   => array('tag'=>'订制预约订单', 'where'=>'type=0'),
			'type1'   => array('tag'=>'套餐预约订单', 'where'=>'type=1'),
			'pay0'   => array('tag'=>'未支付订单', 'where'=>'pay=0'),
			'pay1'   => array('tag'=>'已支付订单', 'where'=>'pay=1'),
			'state0'   => array('tag'=>'作废订单', 'where'=>'state=0'),
			'state1'   => array('tag'=>'已提交订单', 'where'=>'state=1'),
			'state2'   => array('tag'=>'已联络订单', 'where'=>'state=2'),
			'state3'   => array('tag'=>'已完成订单', 'where'=>'state=3')
		);

		//查询全部用户总数
		$count = $ordershoot->where($wheres[$where]['where'])->count();

		//分页查询
		if($count > 0){

			$pageRows = 5; //每页显示条数

			//计算总计页数
			if($count % $pageRows == 0) $pageCount = $count / $pageRows;
			else $pageCount = floor($count / $pageRows) + 1;

			$page = new \Think\Page($count, $pageRows); //实例化分页类对象

			//定义排序规则数组
			$orders = array(
				'id' => array('tag'=>'ID升序排列', 'order'=>'id'),
				'id_desc' => array('tag'=>'ID降序排列', 'order'=>'id desc'),
				'add_time' => array('tag'=>'添加时间升序排列', 'order'=>'add_time'),
				'add_time_desc' => array('tag'=>'添加时间降序排列', 'order'=>'add_time desc'),
				'edit_time' => array('tag'=>'最近编辑时间升序排列', 'order'=>'edit_time'),
				'edit_time_desc' => array('tag'=>'最近编辑时间降序排列', 'order'=>'edit_time desc'),
				'order_time' => array('tag'=>'预约时间升序排列', 'order'=>'order_time'),
				'order_time_desc' => array('tag'=>'预约时间降序排列', 'order'=>'order_time desc'),
			);

			$list = $ordershoot->where($wheres[$where]['where'])->order($orders[$order]['order'])->limit($page->firstRow.','.$page->listRows)->select(); //查询数据
			$admin = M('Admin');
			for($i = 0;$i<count($list);$i++){
				if($list[$i]['admin_id'] == 0){
					$list[$i]['admin_realname'] = '系统';
				}
				else{
					$adminCondition['id'] = $list[$i]['admin_id'];
					$adminResult = $admin->where($adminCondition)->find();
					if($adminResult == false || $adminResult == null){
						$list[$i]['admin_realname'] = '未知';
					}
					else{
						$list[$i]['admin_realname'] = $adminResult['realname'];
					}
				}
			}

			$this->assign('pageRows', $pageRows);
			$this->assign('pageCount', $pageCount);
			$this->assign('orders', $orders);
			$this->assign('list', $list);
			$this->assign('pageNow',$p);// 当前页
		}

		$this->assign('where', $where);
		$this->assign('order', $order);
		$this->assign('wheres', $wheres);
		$this->assign('count', $count);
		$this->display();
	}


	public function edit($id=0, $p = 1, $where = 'all', $order = 'id_desc'){

		if($id == 0){
			$this->error('传递了非法的参数id');
		}
		else{
			$ordershoot = M('Order');
			$ordershootCondition['id'] = $id;
			$orderRow = $ordershoot->where($ordershootCondition)->find();

			if($orderRow){
				if($orderRow['admin_id'] == 0){
					$orderRow['admin_name'] = '系统生成';
				}
				else{
					$admin = M('Admin');
					$conditionAdmin['id'] = $orderRow['admin_id'];
					if($adminData = $admin->where($conditionAdmin)->find()){
						$orderRow['admin_name'] = $adminData['realname'];
					}
				}
				$this->assign('orderRow', $orderRow);

				if($orderRow['type'] == 0){
					//自主订制
					$orderDetail = M('Orderdetail');
					$orderDetailCondition['id'] = $orderRow['link_id'];
					$orderDetailRow = $orderDetail->where($orderDetailCondition)->find();

					if($orderDetailRow){

						$phase = M('phase');
						$phaseCondition['id'] = $orderDetailRow['phase_id'];
						$phaseRow = $phase->where($phaseCondition)->find();
						if($phaseRow){
							$orderDetailRow['phase_name'] = $phaseRow['name'];
						}

						if($orderDetailRow['theme_id'] == 0){
							$orderDetailRow['theme_name'] = '其他主题';
						}
						else{
							$theme = M('Theme');
							$themeCondition['id'] = $orderDetailRow['theme_id'];
							$themeRow = $theme->where($themeCondition)->find();
							if($themeRow){
								$orderDetailRow['theme_name'] = $themeRow['name'];
							}
						}

						$this->assign('orderDetailRow', $orderDetailRow);
					}
				}
				elseif($orderRow['type'] == 1){
					//套餐选择
					$package = M('Package');
					$packageCondition['id'] = $orderRow['link_id'];
					$packageRow = $package->where($packageCondition)->find();
					if($packageRow){
						$this->assign('packageRow', $packageRow);
					}
				}
			}

			$this->assign('pageNow', $p);
			$this->assign('where', $where);
			$this->assign('order', $order);
			$this->assign('id', $id);
			$this->display();
		}
	}

	public function editDo($id=0, $p = 1, $where = 'all', $order = 'id_desc'){

		if($id == 0){//检查id合法性
			$this->error('传递了非法的参数id');
		}
		else{
			$ordershoot = M('Order');
			$orderCondition['id'] = $id;
			$orderRow = $ordershoot->where($orderCondition)->find();
			if($orderRow == false || $orderRow == null){
				$this->error('查无信息');
			}
			else{
				$state = I('post.state');
				$pay = I('post.pay');
				if(!in_array($state, array(0,1,2,3)) || !in_array($pay, array(0,1))){
					$this->error('订单状态或支付状态有误');
				}
				else{
					if($state == $orderRow['state'] && $pay == $orderRow['pay']){
						//无变化
						$this->success('数据无变化', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
					}
					else{
						$orderData['state'] = $state;
						$orderData['pay'] = $pay;
						$orderData['edit_time'] = time();
						$orderData['admin_id'] = session('SNAILKIDS_ADMIN_ID');
						$orderResult = $ordershoot->where($orderCondition)->save($orderData);
						if($orderResult === false){
							$this->error($ordershoot->getError());
						}
						else{
							$this->success('保存成功', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
						}
					}
				}
			}
		}
	}






}