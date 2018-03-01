<?php
namespace Api10\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class UserController extends Controller
{
	/**
	 * 注册/登陆接口
	 * 目前版本只支持第三方注册登录
	 * 包括QQ、微信、微博
	 */
	public function regist($channel=0, $uid=''){

		//如果传递的渠道参数 不是第三方登陆/注册 直接返回参数错误
		if(!in_array($channel, array(2,3,4,'2','3','4'))){
			echoJsonData(C('RESULT_CODE_ARR')['PARAM_ERROR'], null);
			exit;
		}

		//校验传递的uid(第三方登录唯一标识)
		if(strlen($uid) != 32){
			echoJsonData(C('RESULT_CODE_ARR')['PARAM_ERROR'], null);
			exit;
		}
		else{
			$uid = strtolower($uid);
			$uData['uid'] = $uid;
			$userModel = M('User');
			$userObj = $userModel->where($uData)->find();
			if($userObj == NULL){
				//未发现存在记录 本次操作为注册操作
				$nowTime = time();
				$userData = array();
				$userData['username'] = $nowTime.mt_rand(10,99); //随机生成用户名
				$userData['channel'] = $channel;
				$userData['regist_time'] = $nowTime;
				$userData['login_time'] = $nowTime;
				$userData['uid'] = $uid;
				$userData['phone'] = null;
				$userData['password'] = null;
				$userData['enable']	= 1;
				$userData['info_complete'] = 0;
				$addResult = $userModel->add($userData);
				if($addResult){
					//插入数据库成功
					$registData = array(
						'user_id' => $addResult,
						'username' => $userData['username'],
						'info_complete' => $userData['info_complete']
					);
					echoJsonData(C('RESULT_CODE_ARR')['OK'], $registData);
				}
				else{
					//插入数据库失败
					echoJsonData(C('RESULT_CODE_ARR')['POST_ERROR'], null);
					exit;
				}

			}
			elseif($userObj == false){
				//查询出错
				echoJsonData(C('RESULT_CODE_ARR')['QUERY_ERROR'], null);
			}
			else{
				//发现存在记录 本次操作为登录操作
				$loginData = array(
						'user_id' => $userObj['id'],
						'username' => $userObj['username'],
						'info_complete' => $userObj['info_complete']
				);
				echoJsonData(C('RESULT_CODE_ARR')['OK'], $loginData);
			}

		}

	}

	/**
	 * 获取用户信息接口
	 * 根据用户id查询数据库 获取信息
	 */
	public function getInfo($user_id=0){

		$userModel = M('User');
		$userData['id'] = $user_id;
		$userObj = $userModel->where($userData)->find();
		if($userObj == false || $userObj == NULL){
			echoJsonData(C('RESULT_CODE_ARR')['QUERY_ERROR'], null);
		}
		else{
			$info_complete = $userObj['info_complete'];
			$data = array(
					'user_id' => $user_id,
					'username' => $userObj['username'],
					'info_complete' => $info_complete
			);
			if($info_complete == 1){
				//查询详细信息
				$userInfoModel = M('Userinfo');
				$userInfoData['user_id'] = $user_id;
				$userInfoObj = $userInfoModel->where($userInfoData)->find();
				if($userInfoObj == false || $userInfoObj == NULL){
					echoJsonData(C('RESULT_CODE_ARR')['QUERY_ERROR'], null);
				}
				else{
					$data['nickname'] = html_entity_decode($userInfoObj['nickname'], ENT_QUOTES, 'UTF-8');
					$data['sign'] = html_entity_decode($userInfoObj['sign'], ENT_QUOTES, 'UTF-8');
					$data['age'] = html_entity_decode($userInfoObj['age'], ENT_QUOTES, 'UTF-8');
					$data['label_id'] = $userInfoObj['label_id'];
					$data['icon_path'] = $userInfoObj['icon_path'] == '' ? '' : getCompleteAddress($userInfoObj['icon_path']);
					$data['province_id'] = $userInfoObj['province_id'];
					$data['city_id'] = $userInfoObj['city_id'];
					$data['district_id'] = $userInfoObj['district_id'];
				}
			}
			else{
			}

			echoJsonData(C('RESULT_CODE_ARR')['OK'], $data);
		}
	}

	/**
	 * 提交插入用户详细信息接口
	 */
	public function setInfo(){

		//使用post方式接受用户信息并校验
		$infoData = array(
			'user_id' => I('post.user_id'),
			'nickname' => I('post.nickname'),
			'sign' => I('post.sign'),
			'sex' => I('post.sex'),
			'age' => I('post.age'),
			'province_id' => I('post.province_id'),
			'city_id' => I('post.city_id'),
			'district_id' => I('post.district_id')
		);
		$userInfoDModel = D('Userinfo');
		if(!$userInfoDModel->create($infoData)){
			//参数不合法 未能通过自动验证
			echoJsonData(C('RESULT_CODE_ARR')['POST_ERROR'], null);
			exit;
		}
		else{

			//验证通过 查询用户id合法性
			$userModel = M('User');
			$userData = array('id'=> $infoData['user_id']);
			$userRow = $userModel->where($userData)->find();
			if($userRow){
				//用户id合法 检测是否需要更新头像
				$iconPath = '';
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
					if(!$uploadInfo) {// 上传错误提
						echoJsonData(C('RESULT_CODE_ARR')['POST_ERROR'], null);
						exit;
					}
					else{
						$iconPath = $skRootPath.$uploadInfo['savepath'].$uploadInfo['savename'];
					}
				}

				//检测用户详细信息表里是否已经存在该用户数据 如果存在 则本次操作为更新操作 否则是插入操作
				$userInfoModel = M('Userinfo');
				$userInfoData = array('user_id'=> $infoData['user_id']);
				$userInfoRow = $userInfoModel->where($userInfoData)->find();

				if($userInfoRow){

					//详情资料已存在过 更新
					if($iconPath == ''){
						//不需要更图片
						$infoData['icon_path'] = $userInfoRow['icon_path'];
					}
					else{
						$infoData['icon_path'] = $iconPath;
					}
					$saveResult = $userInfoDModel->where('user_id='.$infoData['user_id'])->save($infoData);
					if($saveResult === false){
						//更新失败
						echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'], null);
						exit;
					}
					else{
						//更新成功
						echoJsonData(C('RESULT_CODE_ARR')['OK'], null);
						exit;
					}

				}
				elseif($userInfoRow == null){

					//详情资料未存在过 插入
					$infoData['icon_path'] = $iconPath;
					$addResult = $userInfoDModel->where('user_id='.$infoData['user_id'])->add($infoData);
					if($addResult == false){
						//更新失败
						echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'], null);
						exit;
					}
					else{
						//更新用户表info_complete属性
						$saveData['info_complete'] = 1;
						$userModel->where('id='.$infoData['user_id'])->save($saveData);

						//更新成功
						echoJsonData(C('RESULT_CODE_ARR')['OK'], null);
						exit;
					}
				}


			}
			else{
				//用户id不合法 user表中无此id数据
				echoJsonData(C('RESULT_CODE_ARR')['POST_ERROR'], null);
				exit;
			}
		}

	}

	/**
	 * 设置用户状态接口
	 * 根据参数 用户id 用户label_id
	 */
	public function setLabel($user_id=0, $label_id=0){
		if($user_id == 0 || $label_id == 0){
			echoJsonData(C('RESULT_CODE_ARR')['PARAM_ERROR'], null);
			exit;
		}

		if(!in_array($label_id, array(1,2,3,4,5))){
			echoJsonData(C('RESULT_CODE_ARR')['PARAM_ERROR'], null);
			exit;
		}

		$userInfoModel = M('Userinfo');
		$userInfoData = array('label_id' => $label_id);
		$userInfoSave = $userInfoModel->where('user_id='.$user_id)->save($userInfoData);
		if($userInfoSave){
			echoJsonData(C('RESULT_CODE_ARR')['OK'], null);
			exit;
		}
		else{
			echoJsonData2('请先完善个人信息 再设置状态标签', null);
			exit;
		}

	}

	public function testUser(){
		$this->display();
	}


}