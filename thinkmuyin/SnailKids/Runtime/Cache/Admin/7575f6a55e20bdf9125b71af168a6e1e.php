<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Province Edit</title>
    <!--<link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
			$("#name").focus(function(){
    			$("#alert").html('');
    		});
    		$("#name_en").focus(function(){
    			$("#alert").html('');
    		});
    		$("#alias").focus(function(){
    			$("#alert").html('');
    		});
			
			$("#edit_form").submit(function(){
				var name = $("#name").val();
				var name_en = $("#name_en").val();
				var alias = $("#alias").val();
				if(name == '' || name == null || name_en == '' || name_en == null || alias == '' || alias == null){
					$("#alert").html('<span style="color:#F39C12" class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;&nbsp;Incomplete information!');
					return false;
				}
			});
    	});
    </script>
</head>
<body>

<div class="container-fluid" style="padding: 15px;">
	<div class="row">
		<div class="col-xs-6 sk_col text-left" style="font-size: 14px;">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>城市管理</b>&nbsp;&nbsp;<small style="color: #999999;">City management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;Area&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			City
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		
		<!-- edit -->
		<div class="col-xs-6 sk_col" style="padding-right: 10px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				<div style="font-size:12px;height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE;">
					<div style="float: left;">编辑当前城市</div>
					<div id="alert" style="float: right;"></div>
				</div>
				<div style="clear: both;"></div>
				
				<div>
				<form id="edit_form" method="post" action="/snailkids.php/Admin/City/editDo/p/<?php echo ($p); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
					<input type="text" class="form-control sk_input hidden" id="edit_id" name="id" value="<?php echo ($data["id"]); ?>">
					<div class="form-group" style="margin-top: 15px;">
    					<label for="name">城市名称</label>
    					<input type="text" class="form-control sk_input" id="name" name="name" maxlength="20" placeholder="province name, e.g. 吉林省" value="<?php echo ($data["name"]); ?>">
  					</div>
  					
  					<div class="form-group">
    					<label for="name_en">城市英文名</label>
    					<input type="text" class="form-control sk_input" id="name_en" name="name_en" maxlength="20" placeholder="province english name, e.g. JiLin" value="<?php echo ($data["name_en"]); ?>">
  					</div>
  					
  					<div class="form-group">
    					<label for="alias">城市别名</label>
    					<input type="text" class="form-control sk_input" id="alias" name="alias" maxlength="20" placeholder="province alias name, e.g. 吉林" value="<?php echo ($data["alias"]); ?>">
  					</div>
  					
  					<div class="form-group">
  						<label for="enable">数据可用性</label>
  						<select class="form-control sk_input" id="enable" name="enable">
  							<option value="1" <?php if(($data["enable"] == 1)): ?>selected="selected"<?php endif; ?>>上线&nbsp;Online</option>
  							<option value="0" <?php if(($data["enable"] == 0)): ?>selected="selected"<?php endif; ?>>下线&nbsp;Offline</option>
						</select>
						<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;下线的内容将不会出现在应用程序中</span>
  					</div>
  					
  					<div class="form-group">
    					<label for="edit_time">最近编辑时间</label>
    					<input type="text" class="form-control sk_input" id="edit_time" name="edit_time" value="<?php echo (date("Y-m-d H:i:s",$data["edit_time"])); ?>" disabled>
  					</div>
  					
  					<div class="form-group">
    					<label for="edit_adminRealname">最近编辑管理员</label>
    					<input type="text" class="form-control sk_input" id="edit_adminRealname" name="edit_adminRealname" value="<?php echo ($adminRealname); ?>" disabled>
  					</div>
  					
  					<div>
  						<div class="sk_edit_btn_gp" style="float: left;">
	 						<div class="sk_edit_btn_icon">
	 							<span class="glyphicon glyphicon-edit"></span>
	 						</div>
	 						<input class="sk_edit_btn_ipt" type="submit" value="保存&nbsp;save" />
	 					</div>
	 					
	 					<div class="sk_back_btn_gp" style="float: left; margin-left: 5px;">
	 						<div class="sk_back_btn_icon">
	 							<span class="glyphicon glyphicon-share"></span>
	 						</div>
	 						<a class="sk_back_btn_ipt" href="/snailkids.php/Admin/City/index/p/<?php echo ($p); ?>/order/<?php echo ($order); ?>">放弃&nbsp;back</a>
	 					</div>
	 					<div style="clear: both;"></div>
  					</div>
				</form>
				</div>
			</div>
		</div>
		
	</div>
	
</div>

</body>
</html>