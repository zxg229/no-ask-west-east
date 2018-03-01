<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class CityController extends Controller
{

	public function index($p = 1, $order = 'id', $provinceId = 0){

		$city = M('City'); // 实例化User对象
		if($provinceId == 0){
			$count = $city->where()->count();// 查询满足要求的总记录数
		}
		else{
			$condition['province_id'] = $provinceId;
			$count = $city->where($condition)->count();// 查询满足要求的总记录数
		}

		$this->assign('count', $count);//总共条数

		$province = M('Province');
		$provinces = $province->where('enable=1')->field('id,name')->select();
		//dump($provinces);
		$this->assign('provinces', $provinces); //为添加功能和列表筛选功能 准备数据
		$this->assign('provinceIdNow', ''.$provinceId);

		if($count > 0){
			$pageRows = 10; //每页显示条数
			if($count % $pageRows == 0){
				$totalPage = $count / $pageRows;
			}
			else{
				$totalPage = floor($count / $pageRows) + 1;
			}

			$page = new \Think\Page($count, $pageRows);
			//dump($page);
			//$show = $page->show();// 分页显示输出

			//设置列表头和排序规则
			$theadLinks = array( //列表头初始值
					'id'=>'<span class="sk_thead_title">ID</span><a href="'.__CONTROLLER__.'/index/p/1/order/id/provinceId/'.$provinceId.'" class="sk_thead_link">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort"></span></a>',
					'name'=>'<span class="sk_thead_title">Name</span><a href="'.__CONTROLLER__.'/index/p/1/order/name/provinceId/'.$provinceId.'" class="sk_thead_link">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort"></span></a>',
					'enable'=>'<span class="sk_thead_title">Enable</span><a href="'.__CONTROLLER__.'/index/p/1/order/enable/provinceId/'.$provinceId.'" class="sk_thead_link">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort"></span></a>',
					'edit_time'=>'<span class="sk_thead_title">Edit time</span><a href="'.__CONTROLLER__.'/index/p/1/order/edit_time/provinceId/'.$provinceId.'" class="sk_thead_link">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort"></span></a>'
			);
			switch($order){ //列表头经由参数order而产生的变化
				case 'id':
					$theadLinks['id'] = '<span class="sk_thead_title">ID</span><a href="'.__CONTROLLER__.'/index/p/1/order/id_desc/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes"></span></a>';
					$orderFinal = 'id';
					$orderTitle = 'ID升序排列';
					break;
				case 'id_desc':
					$theadLinks['id'] = '<span class="sk_thead_title">ID</span><a href="'.__CONTROLLER__.'/index/p/1/order/id/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a>';
					$orderFinal = 'id desc';
					$orderTitle = 'ID降序排列';
					break;
				case 'name':
					$theadLinks['name'] = '<span class="sk_thead_title">Name</span><a href="'.__CONTROLLER__.'/index/p/1/order/name_desc/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes"></span></a>';
					$orderFinal = 'name';
					$orderTitle = '名称升序排列';
					break;
				case 'name_desc':
					$theadLinks['name'] = '<span class="sk_thead_title">Name</span><a href="'.__CONTROLLER__.'/index/p/1/order/name/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a>';
					$orderFinal = 'name desc';
					$orderTitle = '名称降序排列';
					break;
				case 'enable':
					$theadLinks['enable'] = '<span class="sk_thead_title">Enable</span><a href="'.__CONTROLLER__.'/index/p/1/order/enable_desc/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes"></span></a>';
					$orderFinal = 'enable';
					$orderTitle = '启用状态升序排列';
					break;
				case 'enable_desc':
					$theadLinks['enable'] = '<span class="sk_thead_title">Enable</span><a href="'.__CONTROLLER__.'/index/p/1/order/enable/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a>';
					$orderFinal = 'enable desc';
					$orderTitle = '启用状态降序排列';
					break;
				case 'edit_time':
					$theadLinks['edit_time'] = '<span class="sk_thead_title">Edit time</span><a href="'.__CONTROLLER__.'/index/p/1/order/edit_time_desc/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes"></span></a>';
					$orderFinal = 'edit_time';
					$orderTitle = '编辑时间升序排列';
					break;
				case 'edit_time_desc':
					$theadLinks['edit_time'] = '<span class="sk_thead_title">Edit time</span><a href="'.__CONTROLLER__.'/index/p/1/order/edit_time/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes-alt"></span></a>';
					$orderFinal = 'edit_time desc';
					$orderTitle = '编辑时间降序排列';
					break;
				default:
					$theadLinks['id'] = '<span class="sk_thead_title">ID</span><a href="'.__CONTROLLER__.'/index/p/1/order/id_desc/provinceId/'.$provinceId.'" class="sk_thead_link_cur">&nbsp;&nbsp;<span class="glyphicon glyphicon-sort-by-attributes"></span></a>';
					$orderFinal = 'id';
					$orderTitle = 'ID升序排列';
			}
			if($provinceId == 0){
				$list = $city->where()->order($orderFinal)->limit($page->firstRow.','.$page->listRows)->select();
			}
			else{
				$condition['province_id'] = $provinceId;
				$list = $city->where($condition)->order($orderFinal)->limit($page->firstRow.','.$page->listRows)->select();
			}

			$this->assign('thead', $theadLinks);
			$this->assign('orderTitle', $orderTitle);
			$this->assign('listRows', $page->listRows);//当前页显示条数
			$this->assign('totalPage', $totalPage);//总共页数
			$this->assign('pageNow',$p);// 当前页
			$this->assign('pageRows', $pageRows);//每页显示条数
			$this->assign('list',$list);// 赋值数据集
			$this->assign('order',$order);// 排序条件
			$this->assign('provinceId',$provinceId);// 省份id
			//$this->assign('page',$show);// 赋值分页输出

			//dump($list);
		}

		$this->display();
	}

	public function edit($id=0, $p = 1, $order='id', $provinceId = 0){

		if($id == 0){
			$this->error('传递了非法的参数id');
		}
		else{
			$city = M('City'); // 实例化User对象
			$condition['id'] = $id;
			$data = $city->where($condition)->find();
			$admin = M('Admin');
			$conditionAdmin['id'] = $data['admin_id'];
			$dataAdmin = $admin->where($conditionAdmin)->find();
			$this->assign('adminRealname', $dataAdmin['realname']);
			$this->assign('data', $data);

			$province = M('Province');
			$provinces = $province->where('enable=1')->field('id,name')->select();
			//dump($provinces);
			$this->assign('provinces', $provinces); //为添加功能和列表筛选功能 准备数据
		}

		$this->assign('p', $p);
		$this->assign('order', $order);
		$this->assign('provinceIdNow', ''.$provinceId);
		$this->display();
	}

	public function addDo(){

		$city = D('City');
		$data = $city->create();
		if(!$data){
			$this->error($city->getError());
		}
		else{
			$now = time();
			$data['add_time'] = $now;
			$data['edit_time'] = $now;
			$data['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if(!$city->add($data)){
				$this->error($city->getError());
			}
			else{
				$this->success('添加成功');
			}
		}
	}

	public function editDo($p = 1, $order='id'){
		$id = I('post.id','');
		if($id == ''){
			$this->error('关键参数丢失id');
		}
		else{
			$province = D('Province');
			$data = $province->create();
			if(!$data){
				$this->error($province->getError());
			}
			else{
				$data['edit_time'] = time();
				$data['admin_id'] = session('SNAILKIDS_ADMIN_ID');

				if($province->save($data) === false){
					$this->error($province->getError());
				}
				else{
					$this->success('保存成功',__CONTROLLER__.'/index/p/'.$p.'/order/'.$order);
				}
			}
		}

	}


}