<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>User Show</title>
    <!--<link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){			

    	});
    </script>
</head>
<body>

<div class="container-fluid" style="padding: 15px;">
	<div class="row">
		<div class="col-xs-6 sk_col text-left" style="font-size: 14px;">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>用户管理</b>&nbsp;&nbsp;<small style="color: #999999;">User management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;User&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			Show
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">

		<!-- show left-->
		<div class="col-xs-3 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #00C0EF;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">用户基础信息</div>
				</div>

				<div style="text-align: center; margin-bottom: 30px;">
					<div style="display: inline-block;">
						<img src="<?php echo (getCompleteAddress($userData["icon"])); ?>" style=" display: block; width: 120px; height: auto; border-radius: 50%;" />
						<div style="margin-top: 10px;" >User - <?php echo ($userData["username"]); ?></div>
					</div>
				</div>
	
				<div>
					<p><b>用户ID：</b>&nbsp;&nbsp;<?php echo ($id); ?></p>
					<p><b>用户名：</b>&nbsp;&nbsp;<?php echo ($userData["username"]); ?></p>
					<p><b>注册渠道：</b>&nbsp;&nbsp;
						<?php switch($userData["channel"]): case "0": ?>测试用户<?php break;?>
							<?php case "1": ?>手机注册用户<?php break;?>
							<?php case "2": ?>QQ注册用户<?php break;?>
							<?php case "3": ?>微信注册用户<?php break;?>
							<?php case "4": ?>微博注册用户<?php break; endswitch;?>
					</p>
					<p><b>注册时间：</b>&nbsp;&nbsp;<?php echo (date("Y-m-d H:i:s",$userData["regist_time"])); ?></p>
					<p><b>最近登录时间：</b>&nbsp;&nbsp;<?php echo (date("Y-m-d H:i:s",$userData["login_time"])); ?></p>
					<p><b>第三方标识：</b>&nbsp;&nbsp;<?php echo ($userData["uid"]); ?></p>
					<p><b>手机号码：</b>&nbsp;&nbsp;<?php echo ($userData["phone"]); ?></p>
					<p><b>手机注册密码：</b>&nbsp;&nbsp;<?php echo ($userData["password"]); ?></p>
					<p><b>用户可用性：</b>&nbsp;&nbsp;
						<?php switch($userData["enable"]): case "0": ?>黑名单用户<?php break;?>
							<?php case "1": ?>白名单用户<?php break; endswitch;?>
					</p>
					<p><b>资料是否完全：</b>&nbsp;&nbsp;
						<?php switch($userData["info_complete"]): case "0": ?>否<?php break;?>
							<?php case "1": ?>是<?php break; endswitch;?>
					</p>
				</div>
			</div>
		</div>
		
		<!-- show middle-->
		<div class="col-xs-4 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #00C0EF;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">用户扩展详情</div>
				</div>
				
				<?php if($userData["info_complete"] == 0): ?>暂无其他扩展信息
				<?php else: ?>
					
				<div>
					<p><b>用户昵称：</b>&nbsp;&nbsp;<?php echo ($userInfoData["nickname"]); ?></p>
					<p><b>用户签名：</b>&nbsp;&nbsp;<?php echo ($userInfoData["sign"]); ?></p>
					<p><b>用户性别：</b>&nbsp;&nbsp;
						<?php switch($userInfoData["sex"]): case "0": ?>女性<?php break;?>
							<?php case "1": ?>男性<?php break; endswitch;?>
					</p>
					<p><b>用户年龄：</b>&nbsp;&nbsp;<?php echo ($userInfoData["age"]); ?></p>
					<p><b>用户标签：</b>&nbsp;&nbsp;<?php echo ($userInfoData["userLabelName"]); ?></p>
					<p><b>头像路径：</b>&nbsp;&nbsp;<?php echo ($userInfoData["icon_path_filename"]); ?></p>
					<p><b>用户所属省份：</b>&nbsp;&nbsp;<?php echo ($userInfoData["userProvinceName"]); ?></p>
					<p><b>用户所属城市：</b>&nbsp;&nbsp;<?php echo ($userInfoData["userCityName"]); ?></p>
					<p><b>用户所属区县：</b>&nbsp;&nbsp;<?php echo ($userInfoData["userDistrictName"]); ?></p>
				</div><?php endif; ?>
				
			</div>
		</div>
		
		<!-- show middle-->
		<div class="col-xs-5 sk_col" style="">
			<div class="sk_option_back" style="border-top-color: #00C0EF;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">用户发布内容</div>
					<div class="col-xs-6 sk_col text-right">
						<a href="/bendi/thinkmuyin/index.php/Admin/User/index/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" class="btn-warning sk_addbtn"><span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;返回</a>
					</div>
				</div>
				
				此功能暂未开通....
				
			</div>
		</div>
		
		
	</div>
	
</div>

</body>
</html>