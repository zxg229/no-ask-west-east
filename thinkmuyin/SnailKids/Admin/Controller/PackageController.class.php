<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class PackageController extends Controller
{
	/**
	 * index方法：显示套餐列表
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function index($p = 1, $where = 'all', $order = 'id_desc'){

		$package = M('Package');

		//定义筛选规则数组
		$wheres = array(
			'all' 	    => array('tag'=>'全部套餐', 'where'=>''),
			'enable0'   => array('tag'=>'下线套餐', 'where'=>'enable=0'),
			'enable1'   => array('tag'=>'上线套餐', 'where'=>'enable=1')
		);

		//查询全部用户总数
		$count = $package->where($wheres[$where]['where'])->count();

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
				'edit_time_desc' => array('tag'=>'最近编辑时间降序排列', 'order'=>'edit_time desc')
			);

			$list = $package->where($wheres[$where]['where'])->order($orders[$order]['order'])->limit($page->firstRow.','.$page->listRows)->select(); //查询数据

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


	/**
	 * add方法：添加一个套餐
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function add($p = 1, $where = 'all', $order = 'id_desc'){

		$this->assign('pageNow',$p);
		$this->assign('where', $where);
		$this->assign('order', $order);
		$this->display();
	}

	public function addDo($p = 1, $where = 'all', $order = 'id_desc'){

		$nowTime = time(); //当前时间

		//照片组上传
		$skRootPath = 'SnailKids/Public/Upload/Package/Image/';
		$config = array(
				'maxSize'    =>    1048576,
				'rootPath'   =>    './'.$skRootPath,
				'savePath'   =>    '',
				'saveName'   =>    '',
				'exts'       =>    array('jpg', 'png', 'jpeg', 'bmp'),
				'autoSub'    =>    true,
				'subName'    =>    array('date','Ym')
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		$imagePathGroup = array();
		$coverPath = '';
		for($i=0; $i<count($_FILES); $i++){
			$index = 'image'.$i;
			$upload->saveName = $nowTime.'_'.mt_rand(1000,9999);
			$uploadInfo = $upload->uploadOne($_FILES[$index]); //上传
			if(!$uploadInfo) {// 上传错误提示错误信息
				$this->error($upload->getError());
			}
			else{
				if($index == 'image0'){
					$coverPath = 'thinkmuyin/'.$skRootPath.$uploadInfo['savepath'].$uploadInfo['savename'];
				}
				else{
					array_push($imagePathGroup, 'thinkmuyin/'.$skRootPath.$uploadInfo['savepath'].$uploadInfo['savename']);
				}
			}
		}

		if(count($imagePathGroup) != 3 || $coverPath == ''){
			$this->error('文件上传有误');
		}
		else{

			$imagePath = implode('|', $imagePathGroup);
			$packageData = array();
			$package = D('Package');
			$packageData['name'] = I('post.name');
			$packageData['alias'] = I('post.alias');
			$packageData['price'] = I('post.price');
			$packageData['content'] = I('post.content');
			$packageData['describe'] = I('post.describe');
			$packageData['cover_path'] = $coverPath;
			$packageData['image_path_group'] = $imagePath;
			$packageData['enable'] = I('post.enable');
			$packageData['add_time'] = $nowTime;
			$packageData['edit_time'] = $nowTime;
			$packageData['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if(!$package->create($packageData)){
				$this->error($package->getError());
			}
			else{
				if(!$package->add($packageData)) {
					$this->error($package->getError());
				}
				else{
					$this->success('添加成功', __CONTROLLER__ . '/index/p/' . $p . '/where/' . $where . '/order/' . $order);
				}
			}
		}
	}

	public function edit($id=0, $p = 1, $where = 'all', $order = 'id_desc'){

		if($id == 0){
			$this->error('传递了非法的参数id');
		}
		else{
			$package = M('Package');
			$packageCondition['id'] = $id;
			$packageRow = $package->where($packageCondition)->find();

			if($packageRow){
				$admin = M('Admin');
				$conditionAdmin['id'] = $packageRow['admin_id'];
				if($adminData = $admin->where($conditionAdmin)->find()){
					$packageRow['admin_name'] = $adminData['realname'];
				}

				$imagePathGroup = explode('|',$packageRow['image_path_group']);
				$packageRow['imagePathGroup'] = $imagePathGroup;
				$this->assign('packageRow', $packageRow);
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
			$package = D('Package');
			$packageCondition['id'] = $id;
			$packageRow = $package->where($packageCondition)->find();
			//查询原照片数组
			$imagePathGroup = explode('|', $packageRow['image_path_group']);
			$coverPath = $packageRow['cover_path'];

			//照片组上传
			$skRootPath = 'SnailKids/Public/Upload/Package/Image/';
			$config = array(
					'maxSize'    =>    1048576,
					'rootPath'   =>    './'.$skRootPath,
					'savePath'   =>    '',
					'saveName'   =>    '',
					'exts'       =>    array('jpg', 'png', 'jpeg', 'bmp'),
					'autoSub'    =>    true,
					'subName'    =>    array('date','Ym')
			);
			$upload = new \Think\Upload($config);// 实例化上传类
			$nowTime = time();

			//循环检测文件是否需要更新上传
			for($i=0;$i<count($_FILES);$i++){
				$index = 'image'.$i;
				if($_FILES[$index]['name'] == '' || $_FILES[$index]['type'] == '' || $_FILES[$index]['size'] == 0){
					//不需要更新
				}
				else{
					$upload->saveName = $nowTime.'_'.mt_rand(1000,9999);
					$uploadInfo = $upload->uploadOne($_FILES[$index]); //上传
					if(!$uploadInfo) {// 上传错误提示错误信息
						$this->error($upload->getError());
					}
					else{
						if($index == 'image0'){
							$coverPath = 'thinkmuyin/'.$skRootPath.$uploadInfo['savepath'].$uploadInfo['savename'];
						}
						else{
							$imagePathGroup[$i-1] =  'thinkmuyin/'.$skRootPath.$uploadInfo['savepath'].$uploadInfo['savename'];
						}
					}
				}
			}

			$imagePath = implode('|', $imagePathGroup);
			$packageData = array();
			$packageData['name'] = I('post.name');
			$packageData['alias'] = I('post.alias');
			$packageData['price'] = I('post.price');
			$packageData['content'] = I('post.content');
			$packageData['describe'] = I('post.describe');
			$packageData['cover_path'] = $coverPath;
			$packageData['image_path_group'] = $imagePath;
			$packageData['enable'] = I('post.enable');
			$packageData['add_time'] = $packageRow['add_time'];
			$packageData['edit_time'] = $nowTime;
			$packageData['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if(!$package->create($packageData)){
				$this->error($package->getError());
			}
			else{
				$result = $package->where($packageCondition)->save($packageData);
				if($result === false){
					$this->error($package->getError());
				}
				else{
					$this->success('保存成功', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
				}
			}
		}
	}






}