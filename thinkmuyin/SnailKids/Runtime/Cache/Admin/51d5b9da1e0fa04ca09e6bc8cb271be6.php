<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Login</title>
    <!--<link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
    <script type="text/javascript">
    </script>
</head>

<body>
	
<div class="container-fluid" style="padding: 15px;">
	
	<div class="row">
		<div class="col-xs-6 sk_col text-left" style="font-size: 14px;">
			<span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;<b>操作提示</b>&nbsp;&nbsp;<small style="color: #999999;">Province management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-volume-down"></span>&nbsp;&nbsp;Alert
		</div>
	</div>
	
	<div class="row" style="margin-top: 100px;">
		<div class="col-xs-4 sk_col"></div>
		<div class="col-xs-4 sk_col">
			<div style="font-size: 16px; height: 20px; line-height: 20px;">
				<span style="color: #DD4B39;" class="glyphicon glyphicon-alert"></span>&nbsp;&nbsp;Oops! Something went wrong.
			</div>
			<div style="margin-top: 15px;">
				<p style="color: #DD4B39; font-weight: bold;"><?php echo($error); ?></p>
				<p>
					Automatically jump after three seconds or click on the link below to manually jump.<br />
					You can also report this error secretly.
				</p>
				<p>
					<a class="btn btn-primary btn-xs" style="padding: 2px 8px; border:0px; background-color: #00C0EF;" id="href" href="<?php echo($jumpUrl); ?>" role="button">Jump</a>
					<a class="btn btn-primary btn-xs" style="padding: 2px 8px; border:0px; background-color: #F39C12;" href="#">Report</a>
					&nbsp;&nbsp;Wait time： <b id="wait"><?php echo($waitSecond); ?></b>
				</p>
			</div>
		</div>
	</div>
	
</div>
	
	
	
	
	
	
<!--<div class="system-message">
<?php if(isset($message)) {?>
<h1>:)</h1>
<p class="success"><?php echo($message); ?></p>
<?php }else{?>
<h1>:(</h1>
<p class="error"><?php echo($error); ?></p>
<?php }?>
<p class="detail"></p>
<p class="jump">
************页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
</p>
</div>-->
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>