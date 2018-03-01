<?php
namespace Api\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class IndexController extends Controller
{

    /**
     * 初始化接口
     */
    public function init(){

        $data = array(
            'update' => array(),
            'package' => array(),
        );

        $upt = array(
            'if_update' => 0,
            'update_url' => ''
        );
        array_push($data['update'], $upt);


        //返回套餐数据
        $package = M('Package');
        $packageWhere['enable'] = 1;
        $packageList = $package->field('id,name,cover_path')->where($packageWhere)->order('id')->select();
        if($packageList){
            foreach($packageList as $pack){
                $tmp = array(
                    'package_id' => $pack['id'],
                    'package_name' => html_entity_decode($pack['name'], ENT_QUOTES, 'UTF-8'),
                    'cover_path' => getCompleteAddress($pack['cover_path'])
                );
                array_push($data['package'], $tmp);
            }
        }

        echoJsonData(C('RESULT_CODE_ARR')['OK'], $data);
    }


    /**
     * index方法：首页接口
     */
    public function index(){

        //定义输出数组
        $data = array(
            'trailer' => array(), //宣传片数据
            'photo'   => array(), //照片组
            'theme'	  => array(), //主题
        );

        //查询宣传片
        $trailer = M('Trailer');
        $conditionTrailer['enable'] = 1;
        $result = $trailer->field('id,thumb_path')->where($conditionTrailer)->order('edit_time desc')->limit(1)->find();
        if($result){
            $data['trailer'] = array(
                'trailer_id' 		 => $result['id'],
                'trailer_thumb_path' => getCompleteAddress($result['thumb_path'])
            );
        }

        //查询照片组
        $photo = M('photo');
        $conditionPhoto['enable'] = 1;
        $result = $photo->field('id,introduce,image_path_group')->where($conditionPhoto)->order('edit_time desc')->limit(3)->select();
        if($result){
            foreach($result as $obj){
                $imagePathGroup = explode('|', $obj['image_path_group']);
                $imageGroup = array();
                foreach($imagePathGroup as $img){
                    array_push($imageGroup, getCompleteAddress($img));
                }
                //dump($imageGroup);
                $tmp = array(
                    'photo_id' => $obj['id'],
                    'photo_introduce' => html_entity_decode($obj['introduce'], ENT_QUOTES, 'UTF-8'),
                    'photo_imageGroup' => $imageGroup
                );
                array_push($data['photo'], $tmp);
            }
        }

        //分主题查询视频样片
        $theme = M('Theme');
        $list = $theme->order('id desc')->select();
        if($list){
            foreach($list as $t){

                $tmp = array(
                    'theme_id' => $t['id'],
                    'theme_name' => html_entity_decode($t['name'], ENT_QUOTES, 'UTF-8'),
                    'theme_introduce' => html_entity_decode($t['introduce'], ENT_QUOTES, 'UTF-8'),
                    'theme_coverPath' => getCompleteAddress($t['cover_path'])
                );
                array_push($data['theme'], $tmp);
            }
        }

        echoJsonData(C('RESULT_CODE_ARR')['OK'], $data);
    }


}