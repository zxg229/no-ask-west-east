<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class TrailerController extends Controller
{
	/**
	 * index方法：显示宣传片列表
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function index($p = 1, $where = 'all', $order = 'id_desc'){

		$trailer = M('Trailer');

		//定义筛选规则数组
		$wheres = array(
			'all' 	    => array('tag'=>'全部宣传片', 'where'=>''),
			'enable0'   => array('tag'=>'下线宣传片', 'where'=>'enable=0'),
			'enable1'   => array('tag'=>'上线宣传片', 'where'=>'enable=1')
		);

		//查询全部用户总数
		$count = $trailer->where($wheres[$where]['where'])->count();

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

			$list = $trailer->where($wheres[$where]['where'])->order($orders[$order]['order'])->limit($page->firstRow.','.$page->listRows)->select(); //查询数据

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
	 * add方法：添加一个宣传片
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

		//缩略图上传
		$skRootPath = 'SnailKids/Public/Upload/Trailer/Thumb/';
		$config = array(
				'maxSize'    =>    1048576,
				'rootPath'   =>    './'.$skRootPath,
				'savePath'   =>    '',
				'saveName'   =>    time().'_'.mt_rand(10,99),
				'exts'       =>    array('jpg', 'png', 'jpeg', 'bmp'),
				'autoSub'    =>    true,
				'subName'    =>    array('date','Ym')
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		$uploadInfo = $upload->uploadOne($_FILES['thumb_path']); //上传
		if(!$uploadInfo) {// 上传错误提示错误信息
			$this->error($upload->getError());
		}
		else {// 上传成功 获取上传文件信息
			$thumbPath = $skRootPath . $uploadInfo['savepath'] . $uploadInfo['savename'];

			$trailerData = array();
			$trailer = D('Trailer');
			$trailerData['name'] = I('post.name');
			$trailerData['thumb_path'] = $thumbPath;
			$trailerData['locally'] = I('post.locally');
			$trailerData['standard_video_path'] = I('post.standard_video_path');
			$trailerData['high_video_path'] = I('post.high_video_path');
			$trailerData['introduce'] = I('post.introduce');
			$trailerData['enable'] = I('post.enable');
			$trailerData['add_time'] = $nowTime;
			$trailerData['edit_time'] = $nowTime;
			$trailerData['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if (!$trailer->create($trailerData)) {
				$this->error($trailer->getError());
			} else {
				if (!$trailer->add($trailerData)) {
					$this->error($trailer->getError());
				} else {
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
			$trailer = M('Trailer');
			$conditionTrailer['id'] = $id;
			$trailerData = $trailer->where($conditionTrailer)->find();

			if($trailerData){
				$admin = M('Admin');
				$conditionAdmin['id'] = $trailerData['admin_id'];
				if($adminData = $admin->where($conditionAdmin)->find()){
					$trailerData['admin_name'] = $adminData['realname'];
				}

				if($trailerData['locally'] == 1){
					$trailerData['current_standard_video_path'] = getCompleteAddress($trailerData['standard_video_path']);
					$trailerData['current_high_video_path'] = getCompleteAddress($trailerData['high_video_path']);
				}
				else{
					$trailerData['current_standard_video_path'] = $trailerData['standard_video_path'];
					$trailerData['current_high_video_path'] = $trailerData['high_video_path'];
				}

				$this->assign('trailerData', $trailerData);
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
			$trailer = D('Trailer');
			$conditionTrailer['id'] = $id;
			$trailerResult = $trailer->where($conditionTrailer)->find();
			$thumbPath = $trailerResult['thumb_path'];

			//检测是否需要更新头像
			if($_FILES['thumb_path']['name'] == '' || $_FILES['thumb_path']['type'] == '' || $_FILES['thumb_path']['size'] == 0){
				//不需要更新
			}
			else{

				//上传新头像
				$skRootPath = 'SnailKids/Public/Upload/Trailer/Thumb/';
				$config = array(
						'maxSize'    =>    1048576,
						'rootPath'   =>    './'.$skRootPath,
						'savePath'   =>    '',
						'saveName'   =>    time().'_'.mt_rand(10,99),
						'exts'       =>    array('jpg', 'png', 'jpeg', 'bmp'),
						'autoSub'    =>    true,
						'subName'    =>    array('date','Ym')
				);
				$upload = new \Think\Upload($config);// 实例化上传类
				$uploadInfo = $upload->uploadOne($_FILES['thumb_path']); //上传
				if(!$uploadInfo) {// 上传错误提示错误信息
					$this->error($upload->getError());
				}
				else{
					$thumbPath = $skRootPath.$uploadInfo['savepath'].$uploadInfo['savename'];
				}
			}

			$trailerData = array();
			$trailerData['name'] = I('post.name');
			$trailerData['thumb_path'] = $thumbPath;
			$trailerData['locally'] = I('post.locally');
			$trailerData['standard_video_path'] = I('post.standard_video_path');
			$trailerData['high_video_path'] = I('post.high_video_path');
			$trailerData['introduce'] = I('post.introduce');
			$trailerData['enable'] = I('post.enable');
			$trailerData['edit_time'] = time();
			$trailerData['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if(!$trailer->create($trailerData)){
				$this->error($trailer->getError());
			}
			else{
				$result = $trailer->where($conditionTrailer)->save($trailerData);
				if($result === false){
					$this->error('%%%'.$trailer->getError());
				}
				else{
					$this->success('保存成功', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
				}
			}
		}
	}






}