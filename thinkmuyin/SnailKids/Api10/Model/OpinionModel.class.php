<?php
namespace Api10\Model;
use Think\Model;

class OpinionModel extends Model{
    protected $_validate = array(

        array('user_id','number','用户id必须存在'),
        array('theme','checkLength20','是否喜欢主题问题必须存在 且不超过20个字符',1,'callback'),
        array('video','checkLength20','是否喜欢样片问题必须存在 且不超过20个字符',1,'callback'),
        array('address','checkLength20','是否喜欢场地问题必须存在 且不超过20个字符',1,'callback'),
        array('opinion','checkLength500','反馈意见必须存在 且不超过500个字符',1,'callback'),
        array('connection','checkLength500','联系方式必须存在 且不超过500个字符',1,'callback'),
        array('add_time','number','提交时间必须存在且为数字'),
    );

    function checkLength20($str){
        $length = strlen($str);
        if($length > 0 && $length <=20){
            return true;
        }
        else{
            return false;
        }
    }

    function checkLength500($str){
        $length = strlen($str);
        if($length > 0 && $length <=500){
            return true;
        }
        else{
            return false;
        }
    }
}