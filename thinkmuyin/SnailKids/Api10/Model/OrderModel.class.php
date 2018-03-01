<?php
namespace Api10\Model;
use Think\Model;

class OrderModel extends Model{
    protected $_validate = array(

        array('realname','checkLength20','姓名必须填写 且不超过20字',1,'callback'),
        array('sex','0,1','性别必须选择',1,'in'),
        array('phone','10000000000,19999999999','手机号必须填写 且格式要合法',1,'between'),
        array('address','checkLength100','预约地址必须填写 且不超过100字',1,'callback'),
        array('address_detail','checkLength100','详细地址必须填写 且不超过100字',1,'callback'),
        array('order_time','checkLength100','预约时间必须填写 且不超过100字',1,'callback'),
        array('note','checkLength500Eq0','特殊说明不能超过500字',0,'callback'),
        array('type','0,1','预约类型未确定',1,'in'),
        array('state','0,1,2,3','预约类型未确定',0,'in'),
        array('pay','0,1','支付状态未确定',0,'in'),
        array('link_id','number','预约类型未确定2',0),
        array('add_time','number','添加时间必须存在且为数字',0),
        array('edit_time','number','编辑时间必须存在且为数字',1),
        array('admin_id','number','管理员id必须存在且为数字',0),

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

    function checkLength100($str){
        $length = strlen($str);
        if($length > 0 && $length <=100){
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

    function checkLength500Eq0($str){
        $length = strlen($str);
        if($length >= 0 && $length <=500){
            return true;
        }
        else{
            return false;
        }
    }



}