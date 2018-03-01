<?php
namespace Admin\Model;
use Think\Model;

class VideoModel extends Model{
    protected $_validate = array(
        array('title','1,100','视频标题必须存在且长度不得超过100',1,'length'),
        array('introduce','1,500','视频介绍必须存在且长度不得超过500',1,'length'),
        array('duration','require','视频时长必须存在'),
        array('theme_id','number','主题id必须存在且为数字'),
        array('cover_path','require','封面路径组必须存在'),
        array('locally',array(0,1),'视频存放位置必须选择0(第三方服务器)或1(本地服务器)',1,'in'),
        array('svideo_path','require','照片路径组必须存在'),
        array('hvideo_path','require','照片路径组必须存在'),
        array('enable',array(0,1),'视频可用性必须选择0(下线)或1(上线)',1,'in'),
        array('add_time','number','添加时间必须存在且为数字'),
        array('edit_time','number','编辑时间必须存在且为数字'),
        array('admin_id','number','管理员id必须存在且为数字'),
    );
}