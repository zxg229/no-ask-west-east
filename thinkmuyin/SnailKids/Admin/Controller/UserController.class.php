<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class UserController extends Controller
{
	/**
	 * index方法：显示用户列表
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function index($p = 1, $where = 'all', $order = 'id_desc'){

		$user = M('User'); // 实例化User表对象
		$userInfo = M('Userinfo'); //实例化userinfo表对象

		//定义筛选规则数组
		$wheres = array(
			'all' 	    => array('tag'=>'全部用户', 'where'=>''),
			'channel0'  => array('tag'=>'测试用户', 'where'=>'channel=0'),
			'channel1'  => array('tag'=>'手机注册用户', 'where'=>'channel=1'),
			'channel2'  => array('tag'=>'QQ注册用户', 'where'=>'channel=2'),
			'channel3'  => array('tag'=>'微信注册用户', 'where'=>'channel=3'),
			'channel4'  => array('tag'=>'微博注册用户', 'where'=>'channel=4'),
			'enable0'   => array('tag'=>'黑名单用户', 'where'=>'enable=0'),
			'enable1'   => array('tag'=>'白名单用户', 'where'=>'enable=1'),
			'complete0' => array('tag'=>'未完善资料用户', 'where'=>'info_complete=0'),
			'complete1' => array('tag'=>'已完善资料用户', 'where'=>'info_complete=1')
		);

		//查询全部用户总数
		$count = $user->where($wheres[$where]['where'])->count();

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
				'regist_time' => array('tag'=>'注册时间升序排列', 'order'=>'regist_time'),
				'regist_time_desc' => array('tag'=>'注册时间降序排列', 'order'=>'regist_time desc'),
				'login_time' => array('tag'=>'最后登录时间升序排列', 'order'=>'login_time'),
				'login_time_desc' => array('tag'=>'最后登录时间降序排列', 'order'=>'login_time desc')
			);

			$list = $user->where($wheres[$where]['where'])->order($orders[$order]['order'])->limit($page->firstRow.','.$page->listRows)->select(); //查询数据

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
	 * add方法：添加一个测试用户
	 * @param int $p 当前页码 从1开始
	 * @param string $order 排序规则
	 * @param string $where 筛选条件
	 */
	public function add($p = 1, $where = 'all', $order = 'id_desc'){

		//准备用户标签数据
		$userLabel = M('Userlabel');
		$labels = $userLabel->where()->select();

		$this->assign('pageNow',$p);
		$this->assign('where', $where);
		$this->assign('order', $order);
		$this->assign('labels',$labels);
		$this->display();
	}

	public function addDo($p = 1, $where = 'all', $order = 'id_desc'){

		$nowTime = time(); //当前时间

		//头像上传
		$skRootPath = 'SnailKids/Public/Upload/User/Icon/';
		$config = array(
				'maxSize'    =>    1048576,
//				'rootPath'   =>    '/Public/Upload/User/Icon/',
				'rootPath'   =>    './'.$skRootPath,
				'savePath'   =>    '',
				'saveName'   =>    time().'_'.mt_rand(10,99),
				'exts'       =>    array('jpg', 'png', 'jpeg', 'bmp'),
				'autoSub'    =>    true,
				'subName'    =>    array('date','Ym')
		);
		$upload = new \Think\Upload($config);// 实例化上传类
		$uploadInfo = $upload->uploadOne($_FILES['icon_path']); //上传
		if(!$uploadInfo) {// 上传错误提示错误信息
			$this->error($upload->getError());
		}
		else{// 上传成功 获取上传文件信息
			$iconPath = $skRootPath.$uploadInfo['savepath'].$uploadInfo['savename'];

			//分别对user和userinfo两个表进行数据验证
			$userData = array();
			$user = D('User');
			$userData['username']      = $nowTime.mt_rand(10,99); //随机生成用户名
			$userData['channel']       = I('post.channel');
			$userData['regist_time']   = $nowTime;
			$userData['login_time']    = $nowTime;
			$userData['enable']		   = I('post.enable');
			$userData['info_complete'] = 1;
			if(!$user->create($userData)){ //user表验证
				$this->error($user->getError());
			}
			else{
				//对userinfo表进行验证
				$userInfoData = array();
				$userInfo = D('Userinfo');
				$userInfoData['nickname']    = I('post.nickname');
				$userInfoData['sign']        = I('post.sign');
				$userInfoData['sex']         = I('post.sex');
				$userInfoData['age']         = I('post.age');
				$userInfoData['label_id']    = I('post.label_id');
				$userInfoData['icon_path']   = $iconPath;
				$userInfoData['province_id'] = I('post.province_id');
				$userInfoData['city_id']     = I('post.city_id');
				$userInfoData['district_id'] = I('post.district_id');
				if(!$userInfo->create($userInfoData)){
					$this->error($userInfo->getError());
				}
				else{
					//验证完成 分步插入
					$result = $user->add($userData); // 写入数据到数据库
					if($result){
						// 如果主键是自动增长型 成功后返回值就是最新插入的值
						$insertId = $result;
						$userInfoData['user_id'] = $insertId;
						if(!$userInfo->add($userInfoData)){
							$this->error($userInfo->getError());
						}
						else{
							$this->success('添加成功');
						}
					}
					else{
						$this->error($user->getError());
					}
				}
			}
		}

	}

	public function test(){
		echo mt_rand(10,99);
	}


	public function edit($id=0, $p = 1, $where = 'all', $order = 'id_desc'){

		if($id == 0){
			$this->error('传递了非法的参数id');
		}
		else{
			$user = M('User');
			$conditionUser['id'] = $id;
			$userData = $user->where($conditionUser)->find();

			$userInfo = M('Userinfo');
			$conditionUserInfo['user_id'] = $id;
			$userInfoData = $userInfo->where($conditionUserInfo)->find();

//			dump($userInfoData);

			$userLabel = M('Userlabel');
			$labels = $userLabel->where()->select();

			$this->assign('userData', $userData);
			$this->assign('userInfoData', $userInfoData);
			$this->assign('pageNow', $p);
			$this->assign('where', $where);
			$this->assign('order', $order);
			$this->assign('id', $id);
			$this->assign('labels', $labels);
			$this->display();
		}
	}

	public function editDo($id=0, $p = 1, $where = 'all', $order = 'id_desc'){

		if($id == 0){//检查id合法性
			$this->error('传递了非法的参数id');
		}
		else{
			$userInfo = D('Userinfo');
			$conditionUserInfo['user_id'] = $id;
			$userInfoResult = $userInfo->where($conditionUserInfo)->find();
			$iconPath = $userInfoResult['icon_path'];

			//检测是否需要更新头像
			if($_FILES['icon_path']['name'] == '' || $_FILES['icon_path']['type'] == '' || $_FILES['icon_path']['size'] == 0){
				//不需要更新
			}
			else{


				//上传新头像
				$skRootPath = 'SnailKids/Public/Upload/User/Icon/';
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
				$uploadInfo = $upload->uploadOne($_FILES['icon_path']); //上传
				if(!$uploadInfo) {// 上传错误提示错误信息
					$this->error($upload->getError());
				}
				else{
					$iconPath = $skRootPath.$uploadInfo['savepath'].$uploadInfo['savename'];
				}
			}

			//对userinfo表进行验证
			$userInfoData = array();
			$userInfoData['nickname']    = I('post.nickname');
			$userInfoData['sign']        = I('post.sign');
			$userInfoData['sex']         = I('post.sex');
			$userInfoData['age']         = I('post.age');
			$userInfoData['label_id']    = I('post.label_id');
			$userInfoData['icon_path']   = $iconPath;
			$userInfoData['province_id'] = I('post.province_id');
			$userInfoData['city_id']     = I('post.city_id');
			$userInfoData['district_id'] = I('post.district_id');
			if(!$userInfo->create($userInfoData)){
				$this->error($userInfo->getError());
			}
			else{
				$result = $userInfo->where($conditionUserInfo)->save($userInfoData);
				if($result === false){
					$this->error('%%%'.$userInfo->getError());
				}
				else{
					$this->success('保存成功', __CONTROLLER__.'/index/p/'.$p.'/where/'.$where.'/order/'.$order);
				}
			}
		}
	}

	public function show($id=0, $p = 1, $where = 'all', $order = 'id_desc'){

		if($id == 0){
			$this->error('传递了非法的参数id');
		}
		else{
			$user = M('User');
			$conditionUser['id'] = $id;
			$userData = $user->where($conditionUser)->find();
			$userData['icon'] = 'SnailKids/Public/Image/user_default.jpg';

			if($userData['info_complete'] == 1){

				$userInfo = M('Userinfo');
				$conditionUserInfo['user_id'] = $id;
				$userInfoData = $userInfo->where($conditionUserInfo)->find();
				$userData['icon'] = $userInfoData['icon_path'];

				$conditionUserLabel['id'] = $userInfoData['label_id'];
				$userLabel = M('Userlabel');
				$labelData = $userLabel->where($conditionUserLabel)->find();
				$userInfoData['userLabelName'] = $labelData['name'];

				$conditionProvince['id'] = $userInfoData['province_id'];
				$province = M('Province');
				$provinceData = $province->where($conditionProvince)->find();
				$userInfoData['userProvinceName'] = $provinceData['name'];

				$conditionCity['id'] = $userInfoData['city_id'];
				$city = M('City');
				$cityData = $city->where($conditionCity)->find();
				$userInfoData['userCityName'] = $cityData['name'];

				$conditionDistrict['id'] = $userInfoData['district_id'];
				$district = M('District');
				$districtData = $district->where($conditionDistrict)->find();
				$userInfoData['userDistrictName'] = $districtData['name'];

				//处理头像路径
				$userInfoData['icon_path_filename'] = str_replace('SnailKids/Public/Upload/User/Icon/','',$userInfoData['icon_path']);



				$this->assign('userInfoData', $userInfoData);
			}

			$this->assign('userData', $userData);
			$this->assign('pageNow', $p);
			$this->assign('where', $where);
			$this->assign('order', $order);
			$this->assign('id', $id);
			$this->display();
		}
	}




}