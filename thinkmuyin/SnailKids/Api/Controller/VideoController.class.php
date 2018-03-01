<?php
namespace Api\Controller;
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


}