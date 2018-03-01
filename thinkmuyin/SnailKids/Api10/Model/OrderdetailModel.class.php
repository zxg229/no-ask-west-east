<?php
namespace Api10\Model;
use Think\Model;

class OrderdetailModel extends Model{
    protected $_validate = array(

        array('phase_id','number','拍摄阶段必须选择',1),
        array('theme_id','number','拍摄主题必须选择',1),
        array('duration','checkLength20','拍摄时长必须选择 且长度不能超过20',1,'callback'),
        array('writting','0,1','是否自撰稿必须选择',1,'in'),
        array('makeup','0,1','是否带妆必须选择',1,'in'),
        array('light','0,1','是否免灯必须选择',1,'in'),
        array('prop','0,1','是否需要额外道具必须选择',1,'in'),
        array('request','0,1','后期是否有特殊要求必须选择',1,'in'),

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


}