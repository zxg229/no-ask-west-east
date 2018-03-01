<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>User Edit</title>
    <!--<link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){			
	
			$("#nickname").focus(function(){
				$("#alert").html('');
			});
			$("#age").focus(function(){
				$("#alert").html('');
			});
			$("#sign").focus(function(){
				$("#alert").html('');
			});
			$("#saveUser").click(function(){
				var nickname = $("#nickname").val();
				var age = $("#age").val();
				var sign = $("#sign").val();
				if(nickname==""||nickname==null||age==""||age==null||sign==""||sign==null){
					$("#alert").html('<span style="color:#F39C12" class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;&nbsp;Incomplete information!');
				}
				else{
					$("#editForm").submit();
				}
			});
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
			Edit
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		<!-- 表单开始 -->
		<form id="editForm" method="post" enctype="multipart/form-data" action="/thinkmuyin/index.php/Admin/User/editDo/id/<?php echo ($id); ?>/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
		
		<!-- edit left-->
		<div class="col-xs-6 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">编辑测试用户</div>
					<div class="col-xs-6 sk_col text-right" id="alert"></div>
				</div>
				
				<div class="form-group">
					<label for="enable">数据可用性</label>
					<select class="form-control sk_input" id="enable" name="enable">
						<option value="1" <?php if($userData["enable"] == 1): ?>selected="selected"<?php endif; ?> >白名单用户</option>
						<option value="0" disabled="disabled">黑名单用户</option>
					</select>
					<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;黑名单用户将无法在客户端进行用户操作</span>
				</div>
				<?php echo ($userInfoData[""]); ?>
				<div class="form-group">
					<label for="nickname">用户昵称</label>
					<input type="text" class="form-control sk_input" id="nickname" name="nickname" maxlength="20" placeholder="小蜗牛先生" value="<?php echo ($userInfoData["nickname"]); ?>">
				</div>
				
				<div class="form-group">
					<label for="sign">用户签名</label>
					<input type="text" class="form-control sk_input" id="sign" name="sign" maxlength="30" placeholder="用户签名长度不超过30" value="<?php echo ($userInfoData["sign"]); ?>">
				</div>
				
				<div class="form-group">
					<label for="sex">用户性别</label>
					<select class="form-control sk_input" id="sex" name="sex">
						<option value="1" <?php if($userInfoData["sex"] == 1): ?>selected="selected"<?php endif; ?> >男性</option>
						<option value="0" <?php if($userInfoData["sex"] == 0): ?>selected="selected"<?php endif; ?> >女性</option>
					</select>
				</div>
				
				<div class="form-group">
					<label for="age">用户年龄</label>
					<input type="text" class="form-control sk_input" id="age" name="age" maxlength="2" placeholder="用户年龄必须是数字" value="<?php echo ($userInfoData["age"]); ?>">
				</div>
				
				<div class="form-group">
					<label for="label_id">用户标签</label>
					<select class="form-control sk_input" id="label_id" name="label_id">
					<?php if(is_array($labels)): foreach($labels as $key=>$v): switch($userInfoData["label_id"]): case $v["id"]: ?><option value="<?php echo ($v["id"]); ?>" selected="selected"><?php echo ($v["name"]); ?></option><?php break;?>
							<?php default: ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endswitch; endforeach; endif; ?>
					</select>
				</div>
			</div>
		</div>
		
		<!-- edit right-->
		<div class="col-xs-6 sk_col" style="padding-left: 5px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
				</div>
				
				<div class="form-group">
    				<label for="icon_path">用户头像</label>
    				<p><img src="<?php echo (getCompleteAddress($userInfoData["icon_path"])); ?>" style="width: auto; height: 100px; border-radius: 2px;"></p>
    				<input type="file" id="icon_path" name="icon_path">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;支持jpg、png、bmp格式图像 文件不得超过1024k</span>

				<div class="form-group">
					<label for="province_id">用户所在省份</label>
					<select class="form-control sk_input" id="province_id" name="province_id">
						<option value="1">北京</option>
					</select>
				</div>
				
				<div class="form-group">
					<label for="city_id">用户所在城市</label>
					<select class="form-control sk_input" id="city_id" name="city_id">
						<option value="1">北京市</option>
					</select>
				</div>
				
				<div class="form-group">
					<label for="district_id">用户所在区县</label>
					<select class="form-control sk_input" id="district_id" name="district_id">
						<option value="1">朝阳区</option>
					</select>
				</div>
				
				<div class="form-group">
					<a id="saveUser" class="btn-success sk_submitbtn" href="#"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;保存 save</a>
					<a id="back" class="btn-warning sk_submitbtn" href="/thinkmuyin/index.php/Admin/User/index/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;放弃 back</a>
				</div>
				
				
			</div>
		</div>
		
		</form><!-- 表单结束 -->
		
	</div>
	
</div>

</body>
</html>