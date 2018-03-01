<?php
/**
 * Created by PhpStorm.
 * User: eddie
 * Date: 2016/6/12
 * Time: 17:26
 */


function echoJsonData($arr, $data){
    //定义输出数组
    $resultArr = array();
    $resultArr['code'] = $arr['code'];
    $resultArr['info'] = $arr['info'];
    $resultArr['data'] = $data;
    echo json_encode($resultArr, JSON_UNESCAPED_UNICODE); //非Unicode输出
    exit;
}

/**
 * 用于输出特殊提示信息的echoJsonData方法
 */
function echoJsonData2($str, $data){
    $resultArr = array(
        'code' => '00',
        'info' => $str,
        'data' => $data
    );
    echo json_encode($resultArr, JSON_UNESCAPED_UNICODE); //非Unicode输出
    exit;
}


/*
 * 时间处理函数 根据秒数确定相距的时间差 返回字符串 如：6天前/3小时前/5分钟前
 */
function getTimeAgo($time) {
    $seconds = time()-$time;

    if (($day = floor ( $seconds / (3600 * 24) )) >= 1) {
        $returnValue = $day . '天前';
    } elseif (($hour = floor ( $seconds / 3600 )) >= 1) {
        $returnValue = $hour . '小时前';
    } elseif (($minute = floor ( $seconds / 60 )) >= 5) {
        $returnValue = $minute . '分钟前';
    } else {
        $returnValue = '刚刚';
    }

    return $returnValue;
}