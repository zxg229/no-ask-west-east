<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class PhotoController extends Controller
{
	/**
	 * index方法：显示照片组列表
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function index($p = 1, $where = 'all', $order = 'id_desc'){

		$photo = M('Photo');

		//定义筛选规则数组
		$wheres = array(
			'all' 	    => array('tag'=>'全部照片组', 'where'=>''),
			'enable0'   => array('tag'=>'下线照片组', 'where'=>'enable=0'),
			'enable1'   => array('tag'=>'上线照片组', 'where'=>'enable=1')
		);

		//查询全部用户总数
		$count = $photo->where($wheres[$where]['where'])->count();

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

			$list = $photo->where($wheres[$where]['where'])->order($orders[$order]['order'])->limit($page->firstRow.','.$page->listRows)->select(); //查询数据

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
	 * add方法：添加一个照片组
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
		$skRootPath = 'SnailKids/Public/Upload/Photo/Image/';
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
		for($i=1; $i<=count($_FILES); $i++){
			$index = 'photo'.$i;
			$upload->saveName = $nowTime.'_'.mt_rand(1000,9999);
			$uploadInfo = $upload->uploadOne($_FILES[$index]); //上传
			if(!$uploadInfo) {// 上传错误提示错误信息
				$this->error($upload->getError());
			}
			else{
				array_push($imagePathGroup, $skRootPath . $uploadInfo['savepath'] . $uploadInfo['savename']);
			}
		}

		if(count($imagePathGroup) != count($_FILES)){
			$this->error('上传文件值不等');
		}
		else{
			$imagePath = implode('|', $imagePathGroup);
			$photoData = array();
			$photo = D('Photo');
			$photoData['name'] = I('post.name');
			$photoData['introduce'] = I('post.introduce');
			$photoData['image_path_group'] = $imagePath;
			$photoData['enable'] = I('post.enable');
			$photoData['add_time'] = $nowTime;
			$photoData['edit_time'] = $nowTime;
			$photoData['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if (!$photo->create($photoData)) {
				$this->error($photo->getError());
			}
			else
			{
				if (!$photo->add($photoData)) {
					$this->error($photo->getError());
				}
				else {
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
			$photo = M('Photo');
			$conditionPhoto['id'] = $id;
			$photoData = $photo->where($conditionPhoto)->find();

			if($photoData){
				$admin = M('Admin');
				$conditionAdmin['id'] = $photoData['admin_id'];
				if($adminData = $admin->where($conditionAdmin)->find()){
					$photoData['admin_name'] = $adminData['realname'];
				}

				$imagePathGroup = explode('|',$photoData['image_path_group']);
				$photoData['imagePathGroup'] = $imagePathGroup;
				$this->assign('photoData', $photoData);
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
			$photo = D('Photo');
			$conditionPhoto['id'] = $id;
			$photoResult = $photo->where($conditionPhoto)->find();
			//查询原照片数组
			$imagePathGroup = explode('|', $photoResult['image_path_group']);

			//照片组上传
			$skRootPath = 'SnailKids/Public/Upload/Photo/Image/';
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

//			dump($_FILES);
//			exit;

			//循环检测文件是否需要更新上传
			for($i=1;$i<=count($_FILES);$i++){
				$index = 'photo'.$i;
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
						$imagePathGroup[$i-1] =  $skRootPath . $uploadInfo['savepath'] . $uploadInfo['savename'];
					}
				}
			}

			$imagePath = implode('|', $imagePathGroup);
			$photoData = array();
			$photoData['name'] = I('post.name');
			$photoData['introduce'] = I('post.introduce');
			$photoData['image_path_group'] = $imagePath;
			$photoData['enable'] = I('post.enable');
			$photoData['edit_time'] = $nowTime;
			$photoData['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if(!$photo->create($photoData)){
				$this->error($photo->getError());
			}
			else{
				$result = $photo->where($conditionPhoto)->save($photoData);
				if($result === false){
					$this->error('%%%'.$photo->getError());
				}
				else{
					$this->success('保存成功', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
				}
			}
		}
	}






}