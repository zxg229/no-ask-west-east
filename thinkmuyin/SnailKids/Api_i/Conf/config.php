<?php
return array(
	//'配置项'=>'配置值'

    //当前最新版本
    'NEWEST_VERSION' => 1.0.1,

    //base_url
    'BASE_URL_ARR' => array(
        '1.0' => 'Api10'
    ),



    //*************************应该删除
    'RESULT_CODE_ARR' => array(
        'OK' => array(
            'code'=>'11',
            'info'=>'ok'),
        'NODATA' => array(
            'code'=>'10',
            'info'=>'暂无数据'),
        'PARAM_ERROR' => array(
            'code'=>'01',
            'info'=>'参数错误'),
        'QUERY_ERROR' => array(
            'code'=>'02',
            'info'=>'查询失败'),
        'POST_ERROR' => array(
            'code'=>'03',
            'info'=>'提交数据错误'),
        'UPDATE_ERROR' => array(
            'code'=>'04',
            'info'=>'提交数据失败'),

    ),
);