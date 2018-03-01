<?php
namespace Admin\Model;
use Think\Model;

class PackageModel extends Model{
    protected $_validate = array(

        array('name','1,100','套餐名称必须存在且长度不得超过100',1,'length'),
        array('alias','1,100','套餐别名必须存在且长度不得超过100',1,'length'),
        array('price',array(1,100000),'套餐价格必须存在且介于1-100000之间',1,'between'),
        array('content','require','套餐内容必须存在',1),
        array('describe','1,200','套餐描述必须存在且长度不得超过200',1,'length'),
        array('cover_path','require','封面路径组必须存在',1),
        array('image_path_group','require','套餐照片组路径组必须存在',1),
        array('enable','require','套餐可用性必须选择0(下线)或1(上线)',1),
        array('add_time','require','添加时间必须存在且为数字',1),
        array('edit_time','require','编辑时间必须存在且为数字',1),
        array('admin_id','number','管理员id必须存在且为数字',1),

    );
}