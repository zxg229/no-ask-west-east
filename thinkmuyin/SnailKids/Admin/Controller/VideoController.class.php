<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class VideoController extends Controller
{
	/**
	 * index方法：显示视频列表
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function index($p = 1, $where = 'all', $order = 'id_desc'){

		$video = M('Video');

		//定义筛选规则数组
		$wheres = array(
			'all' 	    => array('tag'=>'全部视频', 'where'=>''),
			'enable0'   => array('tag'=>'下线视频', 'where'=>'enable=0'),
			'enable1'   => array('tag'=>'上线视频', 'where'=>'enable=1')
		);
		//读取主题库 附加到筛选规则数组
		$theme = M('Theme');
		$themeResult = $theme->where()->select();
		$themeData = array();
		if($themeResult){
			foreach($themeResult as $t){
				$key = 'theme'.$t['id'];
				$wheres[$key] = array(
					'tag'=>$t['name'],
					'where'=>'theme_id='.$t['id']
				);
				$themeData[$t['id']] = $t['name'];
			}
		}

		//查询全部视频总数
		$count = $video->where($wheres[$where]['where'])->count();

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
				'play_num' => array('tag'=>'播放数升序排列', 'order'=>'play_num'),
				'play_num_desc' => array('tag'=>'播放数降序排列', 'order'=>'play_num desc'),
				'praise_num' => array('tag'=>'点赞数升序排列', 'order'=>'praise_num'),
				'praise_num_desc' => array('tag'=>'播放数降序排列', 'order'=>'praise_num desc'),
				'comment_num' => array('tag'=>'评论数升序排列', 'order'=>'comment_num'),
				'comment_num_desc' => array('tag'=>'播放数降序排列', 'order'=>'comment_num desc'),
			);

			$list = $video->where($wheres[$where]['where'])->order($orders[$order]['order'])->limit($page->firstRow.','.$page->listRows)->select(); //查询数据

			$this->assign('pageRows', $pageRows);
			$this->assign('pageCount', $pageCount);
			$this->assign('orders', $orders);
			$this->assign('list', $list);
			$this->assign('themeData', $themeData);
			$this->assign('pageNow',$p);// 当前页
		}

		$this->assign('where', $where);
		$this->assign('order', $order);
		$this->assign('wheres', $wheres);
		$this->assign('count', $count);
		$this->display();
	}


	/**
	 * add方法：添加一个视频
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function add($p = 1, $where = 'all', $order = 'id_desc'){

		$theme = M('Theme');
		$themeData = $theme->where()->select();

		$this->assign('pageNow',$p);
		$this->assign('where', $where);
		$this->assign('order', $order);
		$this->assign('themeData', $themeData);
		$this->display();
	}

	public function addDo($p = 1, $where = 'all', $order = 'id_desc'){

		$nowTime = time(); //当前时间

		//封面上传
		$skRootPath = 'SnailKids/Public/Upload/Video/Cover/';
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
		$uploadInfo = $upload->uploadOne($_FILES['cover_path']); //上传
		if(!$uploadInfo) {// 上传错误提示错误信息
			$this->error($upload->getError());
		}
		else {// 上传成功 获取上传文件信息
			$coverPath = $skRootPath . $uploadInfo['savepath'] . $uploadInfo['savename'];

			$videoData = array();
			$video = D('Video');
			$videoData['title'] = I('post.title');
			$videoData['introduce'] = I('post.introduce');
			$videoData['duration'] = I('post.duration');
			$videoData['theme_id'] = I('post.theme_id');
			$videoData['cover_path'] = $coverPath;
			$videoData['locally'] = I('post.locally');
			$videoData['svideo_path'] = I('post.svideo_path');
			$videoData['hvideo_path'] = I('post.hvideo_path');
			$videoData['enable'] = I('post.enable');
			$videoData['add_time'] = $nowTime;
			$videoData['edit_time'] = $nowTime;
			$videoData['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if (!$video->create($videoData)) {
				$this->error($video->getError());
			} else {
				if (!$video->add($videoData)) {
					$this->error($video->getError());
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
			$video = M('Video');
			$conditionVideo['id'] = $id;
			$videoData = $video->where($conditionVideo)->find();

			if($videoData){
				$admin = M('Admin');
				$conditionAdmin['id'] = $videoData['admin_id'];
				if($adminData = $admin->where($conditionAdmin)->find()){
					$videoData['admin_name'] = $adminData['realname'];
				}

				//查询主题数据
				$theme = M('Theme');
				$themeData = $theme->where()->select();
				$this->assign('themeData', $themeData);
				$this->assign('videoData', $videoData);
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
			$video = D('Video');
			$conditionVideo['id'] = $id;
			$videoResult = $video->where($conditionVideo)->find();
			$coverPath = $videoResult['cover_path'];//查询原视频封面

			//检测上传文件是否需要更新
			if($_FILES['cover_path']['name'] == '' || $_FILES['cover_path']['type'] == '' || $_FILES['cover_path']['size'] == 0){
				//不需要更新
			}
			else{
				//需要更新
				$skRootPath = 'SnailKids/Public/Upload/Video/Cover/';
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
				$uploadInfo = $upload->uploadOne($_FILES['cover_path']); //上传
				if(!$uploadInfo) {// 上传错误提示错误信息
					$this->error($upload->getError());
				}
				else {
					$coverPath = $skRootPath . $uploadInfo['savepath'] . $uploadInfo['savename'];
				}
			}

			//内容验证
			$videoData = array();
			$videoData['title'] = I('post.title');
			$videoData['introduce'] = I('post.introduce');
			$videoData['duration'] = I('post.duration');
			$videoData['theme_id'] = I('post.theme_id');
			$videoData['cover_path'] = $coverPath;
			$videoData['locally'] = I('post.locally');
			$videoData['svideo_path'] = I('post.svideo_path');
			$videoData['hvideo_path'] = I('post.hvideo_path');
			$videoData['enable'] = I('post.enable');
			$videoData['edit_time'] = time();
			$videoData['admin_id'] = session('SNAILKIDS_ADMIN_ID');

			if(!$video->create($videoData)){
				$this->error($video->getError());
			}
			else{
				$result = $video->where($conditionVideo)->save($videoData);
				if($result === false){
					$this->error($video->getError());
				}
				else{
					$this->success('保存成功', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
				}
			}
		}

	}

	/**
	 * 测试用户操作
	 * @param int $id
	 * @param int $p
	 * @param string $where
	 * @param string $order
	 */
	public function option($id=0, $p = 1, $where = 'all', $order = 'id_desc'){

		if($id == 0){//检查id合法性
			$this->error('传递了非法的参数id');
		}
		else{
			//查询视频数据
			$video = M('Video');
			$conditionVideo['id'] = $id;
			$videoData = $video->where($conditionVideo)->find();

			//查询测试用户
			$user = M('User');
			$condiionUser['channel'] = 0;
			$condiionUser['enable'] = 1;
			$userData = $user->field('id,username')->where($condiionUser)->select();
			if($userData){
				$userInfo = M('Userinfo');
				for($i=0;$i<count($userData);$i++){
					$conditionUserInfo['user_id'] = $userData[$i]['id'];
					$userInfoResult = $userInfo->field('nickname')->where($conditionUserInfo)->find();
					$userData[$i]['nickname'] = $userInfoResult['nickname'];
				}
			}

			$this->assign('videoData', $videoData);
			$this->assign('userData', $userData);
			$this->assign('pageNow', $p);
			$this->assign('where', $where);
			$this->assign('order', $order);
			$this->assign('id', $id);
			$this->display();
		}
	}




	public function optionDo($id=0, $p = 1, $where = 'all', $order = 'id_desc'){

		if($id == 0){
			$this->error('传递了非法的参数id');
		}
		else{

			$optionType = I('post.optionType');
			if($optionType == 'praise'){
				$userId = I('post.user_id');

				//查询点赞表
				$videoPraise = M('Videopraise');
				$conditionVideoPraise['video_id'] = $id;
				$videoPraiseResult = $videoPraise->where($conditionVideoPraise)->find();
				if($videoPraiseResult == null){
					//如果没有该视频的点赞数据
					$videoPraiseData['user_id_group'] = $userId;
					$videoPraiseData['video_id'] = $id;
					$result = $videoPraise->add($videoPraiseData);
					if($result){
						//更新video表点赞数据
						$video = M('Video');
						$conditionVideo['id'] = $id;
						$video->where($conditionVideo)->setInc('praise_num');

						$this->success('点赞成功', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
					}
					else{
						$this->error($videoPraise->getError());
					}
				}
				elseif($videoPraiseResult){
					//如果已存在该视频的点赞数据
					$userIdGroup = explode(',', $videoPraiseResult['user_id_group']);
					if(in_array($userId, $userIdGroup)){
						$this->error('该用户已点赞过');
					}
					else{
						array_push($userIdGroup, $userId);
						$videoPraiseData['user_id_group'] = implode(',', $userIdGroup);
						$result = $videoPraise->where($conditionVideoPraise)->save($videoPraiseData);
						if($result === false){
							$this->error($videoPraise->getError());
						}
						else{
							//更新video表点赞数据
							$video = M('Video');
							$conditionVideo['id'] = $id;
							$video->where($conditionVideo)->setInc('praise_num');

							$this->success('点赞成功', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
						}
					}
				}
			}
			elseif($optionType == 'comment'){

				$videoComment = M('Videocomment');
				$videoCommentData = array();
				$videoCommentData['video_id'] = $id;
				$videoCommentData['user_id'] = I('post.user_id');
				$videoCommentData['comment'] = I('post.comment');
				$videoCommentData['enable'] = 1;
				$videoCommentData['comment_time'] = time();

				$result = $videoComment->add($videoCommentData);
				if(!$result){
					$this->error($videoComment->getError());
				}
				else{
					$video = M('Video');
					$conditionVideo['id'] = $id;
					$video->where($conditionVideo)->setInc('comment_num');
					$this->success('添加成功', __CONTROLLER__ . '/index/p/' . $p . '/where/' . $where . '/order/' . $order);
				}
			}

		}




	}






}