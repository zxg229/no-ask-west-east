<?php
namespace Admin\Model;
use Think\Model;

class CityModel extends Model{
    protected $_validate = array(
        array('name','require','城市名称必须填写'),
        array('name_en','require','城市英文名称必须填写'),
        array('alias','require','城市别名必须填写'),
        array('enable','require','数据可用性必须选择'),
        array('province_id','require','所属省份必须选择'),
    );
}