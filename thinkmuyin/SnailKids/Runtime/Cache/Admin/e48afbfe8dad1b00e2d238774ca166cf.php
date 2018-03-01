<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Top</title>
    <!--<link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
    <style type="text/css">
    	.nav_a{color: #FFFFFF;}
    	.nav_a:hover{color: #122B40;}
    </style>
</head>
<body>
	
	
	
<div class="container-fluid" style="width:100%; height: 50px; background-color: #3C8DBC;">
	<div style="float: left; width: 230px; background-color: #3678A9; height:50px; line-height:50px; font-size: 20px; text-align: center;">
		<b>Snail</b><span style="color: #CC0000;">KIDS</span>
	</div>
	<div style="float: right; width: 300px; height:50px; line-height:50px; color: #FFFFFF; font-size: 14px;">
		
		<div style="float: right;margin-right: 15px;">
			<?php echo (session('SNAILKIDS_ADMIN_USERNAME')); ?>&nbsp;&nbsp;
			<a title="setting" class="nav_a" href="#"><span class="glyphicon glyphicon-cog"></span></a>
		</div>
		
		<div style="float: right;margin-right: 15px;">
			<img src="<?php echo (ADMIN_PUBLIC_IMGS); ?>default_user_icon.jpg" class="img-responsive" style="width: 27px; height: 27px; margin-top: 11px; border-radius: 50%;" />
		</div>
		<div style="float: right; margin-right: 15px;">
			<a title="Log out" class="nav_a" href="/bendi/thinkmuyin/index.php/Admin/Index/login" target="_parent"><span class="glyphicon glyphicon-log-out"></span></a>&nbsp;&nbsp;
			<a title="message" class="nav_a" href="#"><span class="glyphicon glyphicon-envelope"></span></a>&nbsp;&nbsp;
			<a title="notice" class="nav_a" href="#"><span class="glyphicon glyphicon-flag"></span></a>
		</div>
	</div>
</div>
	
	

</body>
</html>