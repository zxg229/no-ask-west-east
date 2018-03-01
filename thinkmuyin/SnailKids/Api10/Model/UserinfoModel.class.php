<?php
namespace Api10\Model;
use Think\Model;

class UserinfoModel extends Model{
    protected $_validate = array(

        array('user_id','number','用户id必须存在'),
        array('nickname','checkLength50','昵称必须存在 且不超过20个字符',1,'callback'),
        array('sign','checkLength100','昵称必须存在 且不超过100个字符',1,'callback'),
        array('sex','0,1','性别必须选择',1,'in'),
        array('age','number','年龄必须存在且为数字',1),
        array('province_id','number','所在省份必须存在且必须为数字'),
        array('city_id','number','所在城市必须存在且必须为数字'),
        array('district_id','number','所在区县必须存在且必须为数字'),
    );

    function checkLength50($str){
        $length = strlen($str);
        if($length > 0 && $length <=50){
            return true;
        }
        else{
            return false;
        }
    }

    function checkLength100($str){
        $length = strlen($str);
        if($length > 0 && $length <=100){
            return true;
        }
        else{
            return false;
        }
    }
}