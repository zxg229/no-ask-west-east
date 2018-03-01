<?php
namespace Api\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class ThemeController extends Controller
{
	/**
	 * index方法：主题页接口 分选项卡显示
	 */
	public function index($themeId = 1, $p = 1){

		$video = M('Video');

		$videoCondition['theme_id'] = $themeId;
		$videoCondition['enable'] = 1;

		$pageRows = 5;
		$count = $video->where($videoCondition)->count();
		$page = new \Think\Page($count, $pageRows);

		$list = $video->field('id,title,duration,cover_path,play_num,praise_num,comment_num')->where($videoCondition)->order('edit_time desc')->limit($page->firstRow.','.$page->listRows)->select();
		if($list === false){
			echoJsonData(C('RESULT_CODE_ARR')['QUERY_ERROR'], null);
		}
		elseif($list == null){
			echoJsonData(C('RESULT_CODE_ARR')['NODATA'], null);
		}
		else{
			$data = array();

			foreach($list as $v){
				$tmp = array(
					'video_id' => $v['id'],
					'title' => html_entity_decode($v['title'], ENT_QUOTES, 'UTF-8'),
					'duration' => html_entity_decode($v['duration'], ENT_QUOTES, 'UTF-8'),
					'cover_path' => getCompleteAddress($v['cover_path']),
					'play_num' => $v['play_num'],
					'praise_num' => $v['praise_num'],
					'comment_num' => $v['comment_num']
				);
				array_push($data, $tmp);
			}

			if(count($data) <= 0){
				echoJsonData(C('RESULT_CODE_ARR')['NODATA'], null);
			}
			else{
				echoJsonData(C('RESULT_CODE_ARR')['OK'], $data);
			}
		}
	}


}