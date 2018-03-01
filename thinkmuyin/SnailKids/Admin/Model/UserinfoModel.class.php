<?php
namespace Admin\Model;
use Think\Model;

class UserinfoModel extends Model{
    protected $_validate = array(
        array('nickname','1,20','用户昵称必须存在且长度不得超过20',1,'length'),
        array('sign','1,100','用户签名必须存在且长度不得超过30',1,'length'),
        array('sex',array(0,1),'用户性别必须选择0(女)或1(男)',1,'in'),
        array('age','number','用户年龄必须存在且必须为数字'),
        array('label_id','number','用户标签必须存在且必须为数字id'),
        array('icon_path','require','用户头像路径必须存在'),
        array('province_id','number','所在省份必须存在且必须为数字'),
        array('city_id','number','所在城市必须存在且必须为数字'),
        array('district_id','number','所在区县必须存在且必须为数字'),
    );
}