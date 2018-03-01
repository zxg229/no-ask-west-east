<?php
namespace Api_i\Controller;

use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class IndexController extends Controller
{
    /**
     * 初始化接口
     * 1.客户端版本检测 提示是否升级
     * 2.根据客户端版本返回适合的base_url
     * 3.返回活动页和协议页完整地址
     */
    public function init($version=0,$channel='',$count=0){

        //定义接口返回格式
        $data = array(
            'update' => array(),
            'base_url' => '',
            'active_url' => '',
            'agreement_url' => ''
        );

        //检测版本更新
        $clientVersion = floatval($version); //获取客户端传递的版本参数并转换成浮点数
        if($clientVersion < C('NEWEST_VERSION')){
            $data['update'] = array(
                'if_update' => 1,
                'update_url' => 'http://'.$_SERVER ['HTTP_HOST'].'/SnailKids/Public/Download/SnailKids1.1.apk'
            );
        }
        else{
            $data['update'] = array(
                'if_update' => 0,
                'update_url' => ''
            );
        }

        //返回base_url
        if($version == 0){$version = 1.0;}
        if(array_key_exists($version, C('BASE_URL_ARR'))){
            $data['base_url'] = 'http://'.$_SERVER ['HTTP_HOST'].'/snailkids.php/'.C('BASE_URL_ARR')[$version].'/';
        }
        else{
            //如果客户端传来的版本号 不是配置数组的键 那么返回最新的base_url
            $data['base_url'] = 'http://'.$_SERVER ['HTTP_HOST'].'/snailkids.php/'.C('BASE_URL_ARR')['1.0'].'/';
        }

        //返回活动页和协议页完整地址
        $data['active_url'] = $data['base_url'].'Active/index';
        $data['agreement_url'] = $data['base_url'].'Agreement/index';

        //检测是否需要进行启动统计
        if($count == 1 && $channel != ''){
            $bootCount = M('Bootcount');
            $conditionBootCount['channel'] = $channel;
            $bootCount->where($conditionBootCount)->setInc('count');
        }

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
     * index方法：首页接口 ******************************************  应该删除
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