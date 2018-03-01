<?php
namespace Admin\Model;
use Think\Model;

class UserModel extends Model{
    protected $_validate = array(
        array('username','1,20','用户名必须存在且长度不得超过20',1,'length'),
        array('channel','number','用户渠道必须存在且必须为数字'),
        array('regist_time','number','注册时间必须存在且必须为数字'),
        array('login_time','number','登录时间必须存在且必须为数字'),
        array('enable',array(0,1),'用户可用性必须选择0(黑名单)或1(白名单)',1,'in'),
        array('info_complete',array(0,1),'资料完成度必须选择0(未完善)或1(已完善)',1,'in'),
    );
}