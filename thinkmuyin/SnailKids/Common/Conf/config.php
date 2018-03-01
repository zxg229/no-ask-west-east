<?php
return array(
	//'配置项'=>'配置值'

    //数据库连接
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'sailkids',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '123456',          // 密码
//    'DB_PWD'                =>  '68730172``~~',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'sk_',    // 数据库表前缀

    'DEFAULT_FILTER'        =>  'htmlentities_custom', // 默认参数过滤方法 用于I函数... 使用了自定义的过滤方法 在模块下Common下Common目中定义function.php文件
);