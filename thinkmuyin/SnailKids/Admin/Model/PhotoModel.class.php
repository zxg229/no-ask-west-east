<?php
namespace Admin\Model;
use Think\Model;

class PhotoModel extends Model{
    protected $_validate = array(
        array('name','1,100','照片组名称必须存在且长度不得超过100',1,'length'),
        array('introduce','1,500','照片组简介必须存在且长度不得超过500',1,'length'),
        array('image_path_group','require','照片路径组必须存在'),
        array('enable',array(0,1),'照片组可用性必须选择0(下线)或1(上线)',1,'in'),
        array('add_time','number','添加时间必须存在且为数字'),
        array('edit_time','number','编辑时间必须存在且为数字'),
        array('admin_id','number','管理员id必须存在且为数字'),
    );
}