<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./SnailKids/');

	//定义应用目录
	//define('APP_PATH','./App/');
 //定义应用需要用到的常量信息
	define('SITE_URL','http://localhost/bendi/thinkmuyin/SnailKids/');
    define('ADMIN_PUBLIC_CSS',SITE_URL.'Admin/Public/css/');//后台css常量
    define('ADMIN_PUBLIC_IMGS',SITE_URL.'Admin/Public/imgs/');//后台图片
    define('ADMIN_PUBLIC_JS',SITE_URL.'Admin/Public/js/');//后台图片

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单