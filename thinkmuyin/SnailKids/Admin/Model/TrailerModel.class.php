<?php
namespace Admin\Model;
use Think\Model;

class TrailerModel extends Model{
    protected $_validate = array(
        array('name','1,100','宣传片名必须存在且长度不得超过100',1,'length'),
        array('thumb_path','require','缩略图路径必须存在'),
        array('locally',array(0,1),'宣传片存放位置必须选择0(第三方服务器)或1(本地服务器)',1,'in'),
        array('standard_video_path','1,100','标清视频地址必须存在且长度不得超过100',1,'length'),
        array('high_video_path','1,100','高清视频地址必须存在且长度不得超过100',1,'length'),
        array('introduce','1,500','宣传片简介必须存在且长度不得超过500',1,'length'),
        array('enable',array(0,1),'宣传片可用性必须选择0(下线)或1(上线)',1,'in'),
        array('add_time','number','添加时间必须存在且为数字'),
        array('edit_time','number','编辑时间必须存在且为数字'),
        array('admin_id','number','管理员id必须存在且为数字'),
    );
}