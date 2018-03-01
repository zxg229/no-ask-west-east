<?php
namespace Admin\Model;
use Think\Model;

class ProvinceModel extends Model{
    protected $_validate = array(
        array('name','require','省份名称必须填写'),
        array('name_en','require','省份英文名称必须填写'),
        array('alias','require','省份别名必须填写'),
        array('enable','require','数据可用性必须选择'),
    );
}