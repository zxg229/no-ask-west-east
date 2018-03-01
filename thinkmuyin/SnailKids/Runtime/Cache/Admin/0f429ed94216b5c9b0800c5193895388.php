<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Welcome</title>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
</head>
<body>
	
	
	
<div class="container-fluid">
	Welcome.<?php echo ($md5); ?>.<?php echo ($time); ?><br />
	<?php echo (getCompleteAddress($md5)); ?><br />
	<?php echo (ADMIN_PUBLIC); ?>UEditor/umeditor.config.js
	<img src="<?php echo (ADMIN_PUBLIC); ?>UEditor/default_user_icon.jpg" />
	<!-- 加载编辑器的容器 -->
    <script id="container" name="content" type="text/plain">
        这里写你的初始化内容
    </script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="<?php echo (ADMIN_PUBLIC); ?>UEditor/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="<?php echo (ADMIN_PUBLIC); ?>UEditor/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>

</div>
	
	

</body>
</html>