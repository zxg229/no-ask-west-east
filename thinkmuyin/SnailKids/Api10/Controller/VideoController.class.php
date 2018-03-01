<?php
namespace Api10\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class VideoController extends Controller
{
	/**
	 * index方法：视频样片详情页
	 */
	public function index($videoId = 1){

		$video = M('Video');
		$videoCondition['id'] = $videoId;
		$videoCondition['enable'] = 1;

		$row = $video->where($videoCondition)->find();
		if($row === false){
			echoJsonData(C('RESULT_CODE_ARR')['QUERY_ERROR'], null);
		}
		elseif($row == null){
			echoJsonData(C('RESULT_CODE_ARR')['NODATA'], null);
		}
		else{
			$data = array();

			$data['video_id'] = $videoId;
			$data['title'] = html_entity_decode($row['title'], ENT_QUOTES, 'UTF-8');
			$data['duration'] = html_entity_decode($row['duration'], ENT_QUOTES, 'UTF-8');
			$data['introduce'] = html_entity_decode($row['introduce'], ENT_QUOTES, 'UTF-8');
			$data['cover_path'] = getCompleteAddress($row['cover_path']);
			$data['svideo_path'] = getCompleteAddress($row['svideo_path']);
			$data['hvideo_path'] = getCompleteAddress($row['hvideo_path']);
			$data['praise_num'] = $row['praise_num'];
			$data['comment_num'] = $row['comment_num'];
			$data['praise_group'] = array();
			$data['comment_group'] = array();

			//播放次数+1
			$video->where($videoCondition)->setInc('play_num');

			$userInfo = M('Userinfo');

			//查询点赞列表
			$videoPraise = M('Videopraise');
			$videoPraiseCondition['video_id'] = $videoId;
			$videoPraiseRow = $videoPraise->where($videoPraiseCondition)->find();
			if($videoPraiseRow){
				$userIdGroup = explode(',', $videoPraiseRow['user_id_group']);
				$nums = 0; //默认只显示十个头像
				end($userIdGroup);
				while(($userId = current($userIdGroup)) != false){

					$userInfoCondition['user_id'] = $userId;
					$userInfoRow = $userInfo->where($userInfoCondition)->find();
					if($userInfoRow){
						$tmp = array(
							'praise_user_id' => $userId,
							'praise_icon_path' => getCompleteAddress($userInfoRow['icon_path'])
						);
						array_push($data['praise_group'], $tmp);
						prev($userIdGroup);
						$nums++;
						if($nums >= 10)
							break;
					}
				}
			}

			//查询评论列表
			$videoComment = M('Videocomment');
			$videoCommentCondition['video_id'] = $videoId;
			$videoCommentCondition['enable'] = 1;
			$videoCommentList = $videoComment->where($videoCommentCondition)->order('comment_time desc')->limit(5)->select();
			if($videoCommentList){
				foreach($videoCommentList as $c){
					$userInfoCondition['user_id'] = $c['user_id'];
					$userInfoRow = $userInfo->where($userInfoCondition)->find();
					if($userInfoRow){
						$tmp = array(
								'comment_user_id' => $c['user_id'],
								'comment_icon_path' => getCompleteAddress($userInfoRow['icon_path']),
								'comment_nickname' => html_entity_decode($userInfoRow['nickname'], ENT_QUOTES, 'UTF-8'),
								'comment_time' => getTimeAgo($c['comment_time']),
								'comment' => html_entity_decode($c['comment'], ENT_QUOTES, 'UTF-8'),
						);
						array_push($data['comment_group'], $tmp);
					}
				}
			}

			echoJsonData(C('RESULT_CODE_ARR')['OK'], $data);


		}
	}

	/**
	 * 视频样片点赞接口
	 * @param int $video_id 样片id
	 * @param int $user_id 用户id
	 * 方法检测过程：
	 * 1.检测传递参数合法性
	 * 2.检测数据库中 是否有该条样片的点赞记录 没有则插入 有则更新
	 * 3.检测当前用户是否对该条样片点赞过
	 * 4.更新样片数据的点赞数
	 */
	public function praise($video_id=0, $user_id=0){

		//1.检测传递参数合法性
		if($video_id == 0 || $user_id == 0){
			echoJsonData(C('RESULT_CODE_ARR')['PARAM_ERROR'], null);
			exit;
		}

		//2.检测数据库中 是否有该条样片的点赞记录 没有则插入 有则更新
		$videoModel = M('Video');
		$vPraiseModel = M('Videopraise');
		$vPraiseWhere = array('video_id'=>$video_id);
		$vPraiseRow = $vPraiseModel->where($vPraiseWhere)->find();
		if($vPraiseRow){
			//存在点赞记录
			//3.检测当前用户是否对该条样片点赞过
			if(in_array($user_id, explode(',',$vPraiseRow['user_id_group']))){
				//用户点赞过
				echoJsonData2('用户已经对此样片点赞过', null);
				exit;
			}
			else{
				//用户没有点赞过
				//检测用户资料是否完善
				$userModel = M('User');
				$userRow = $userModel->where('id='.$user_id)->find();
				if(!$userRow || $userRow['info_complete'] == 0){
					//用户不合法
					echoJsonData2('用户未完善资料或身份不合法', null);
					exit;
				}


				//更新记录
				$vPraiseData = array(
					'user_id_group' => $vPraiseRow['user_id_group'].','.$user_id
				);
				$vPraiseSave = $vPraiseModel->where('id='.$vPraiseRow['id'])->save($vPraiseData);
				//dump($vPraiseRow['id']);
				if($vPraiseSave){
					//更新成功
					//4.更新样片数据的点赞数
					$videoModel->where('id='.$video_id)->setInc('praise_num');
					echoJsonData(C('RESULT_CODE_ARR')['OK'], null);
					exit;
				}
				else{
					//更新失败
					echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'], null);
					exit;
				}
			}
		}
		else{
			//不存在点赞记录
			//插入记录
			$vPraiseData = array(
				'video_id' => $video_id,
				'user_id_group' => $user_id
			);
			$vPraiseAdd = $vPraiseModel->add($vPraiseData);
			if($vPraiseAdd){
				//插入成功
				//4.更新样片数据的点赞数
				$videoModel->where('id='.$video_id)->setInc('praise_num');
				echoJsonData(C('RESULT_CODE_ARR')['OK'], null);
				exit;
			}
			else{
				//插入失败
				echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'], null);
				exit;
			}
		}

	}

	/**
	 * 用户对样片评论接口
	 * 接口访问方式post
	 * 1.接收post变量
	 * 2.检测用户合法性 即详细资料是否完善
	 * 3.对用户提交的评论内容进行字数检测
	 * 4.插入数据 并更新样片评论数
	 */
	public function comment(){

		//1.接收post变量
		$video_id = I('post.video_id');
		$user_id = I('post.user_id');
		$comment = I('post.comment');

		//2.检测用户合法性 即详细资料是否完善
		$userModel = M('User');
		$userRow = $userModel->where('id='.$user_id)->find();
		if(!$userRow || $userRow['info_complete'] == 0){
			//用户不合法
			echoJsonData2('用户未完善资料或身份不合法', null);
			exit;
		}

		//3.对用户提交的评论内容进行字数检测
		$cLength = strlen($comment);
		if($cLength <= 0 || $cLength > 500){
			//评论字数不合法
			echoJsonData2('用户提交的评论内容字数不合法', null);
			exit;
		}

		//4.插入数据 并更新样片评论数
		$vCommentModel = M('Videocomment');
		$vCommentData = array(
			'video_id' => $video_id,
			'user_id' => $user_id,
			'comment' => $comment,
			'enable' => 1,
			'comment_time' => time()
		);
		$vCommentAdd = $vCommentModel->add($vCommentData);
		if($vCommentAdd){
			//添加成功 更新评论数
			$videoModel = M('Video');
			$videoModel->where('id='.$video_id)->setInc('comment_num');
			echoJsonData(C('RESULT_CODE_ARR')['OK'], null);
			exit;
		}
		else{
			//添加失败
			echoJsonData(C('RESULT_CODE_ARR')['UPDATE_ERROR'], null);
			exit;
		}

	}

	/**
	 * 视频样片分享方法
	 * 模板webview页面
	 * @param int $v
	 */
	public function share($v=1){

		//获取视频信息
		$videoModel = M('Video');
		$videoRow = $videoModel->where('id='.$v)->find();
		if($videoRow){

			//主题信息
//			$themeId = $videoRow['theme_id'];
//			$themeModel = M('Theme');
//			$themeRow = $themeModel->where('id='.$themeId)->find();
//			if($themeRow){
//				$this->assign('themeName',html_entity_decode($themeRow['name'], ENT_QUOTES, 'UTF-8'));
//			}

			$this->assign('videoTitle',html_entity_decode($videoRow['title'], ENT_QUOTES, 'UTF-8'));
			$this->assign('videoTime',date('Y-m-d H:i',$videoRow['edit_time']));
			$this->assign('videoCover',getCompleteAddress($videoRow['cover_path']));
			$this->assign('videoPath',getCompleteAddress($videoRow['hvideo_path']));
			$this->assign('videoPraise',$videoRow['praise_num']);
			$this->assign('videoComment',$videoRow['comment_num']);
			$this->assign('videoPlay',$videoRow['play_num']);
			$this->assign('videoIntroduce',html_entity_decode($videoRow['introduce'], ENT_QUOTES, 'UTF-8'));

		}


		$this->assign('backImg',getCompleteAddress('SnailKids/Public/Image/s_back.png'));

		//echo html_entity_decode($videoRow['title'], ENT_QUOTES, 'UTF-8').'<br />';



		$this->display();
	}

	/**
	 * 表单测试用户评论
	 */
	public function testComment(){
		$this->display();
	}


	public function share1(){

		$this->assign('iii', 'http://101.201.105.130/SnailKids/Public/Upload/User/Icon/201606/1465894240_722.jpg');
		$this->display();
	}

}