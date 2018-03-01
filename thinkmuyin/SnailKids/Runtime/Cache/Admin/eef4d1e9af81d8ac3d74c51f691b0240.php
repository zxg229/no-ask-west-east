<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Package Add</title>
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
			$("#alias").focus(function(){
				$("#alert").html('');
			});
			$("#price").focus(function(){
				$("#alert").html('');
			});
			$("#content").focus(function(){
				$("#alert").html('');
			});
			$("#describe").focus(function(){
				$("#alert").html('');
			});
			$("#image0").focus(function(){
				$("#alert").html('');
			});
			$("#image1").focus(function(){
				$("#alert").html('');
			});
			$("#image2").focus(function(){
				$("#alert").html('');
			});
			$("#image3").focus(function(){
				$("#alert").html('');
			});
			
			$("#addLink").click(function(){		
				var name = $("#name").val();
				var alias = $("#alias").val();
				var price = $("#price").val();
				var content = $("#content").val();
				var describe = $("#describe").val();
				var image0 = $("#image0").val();
				var image1 = $("#image1").val();
				var image2 = $("#image2").val();
				var image3 = $("#image3").val();
				if(name==""||name==null||alias==""||alias==null||price==""||price==null||content==""||content==null||describe==""||describe==null||image0==""||image0==null||image1==""||image1==null||image2==""||image2==null||image3==""||image3==null){
					$("#alert").html('<span style="color:#F39C12" class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;&nbsp;Incomplete information!');
				}
				else{
					$("#addForm").submit();
				}
			});
			
    	});
    </script>
</head>
<body>

<div class="container-fluid" style="padding: 15px;">
	<div class="row">
		<div class="col-xs-6 sk_col text-left" style="font-size: 14px;">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>套餐</b>&nbsp;&nbsp;<small style="color: #999999;">Package management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;Package&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			Add
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		<!-- 表单开始 -->
		<form id="addForm" method="post" enctype="multipart/form-data" action="/bendi/thinkmuyin/index.php/Admin/Package/addDo/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
		
		<!-- add left-->
		<div class="col-xs-6 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #3C8DBC;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">添加一个套餐</div>
					<div class="col-xs-6 sk_col text-right" id="alert"></div>
				</div>
				
				<div class="form-group">
					<label for="name">套餐名称</label>
					<input type="text" class="form-control sk_input" id="name" name="name" maxlength="50" placeholder="F1经典">
				</div>
				
				<div class="form-group">
					<label for="alias">套餐别名</label>
					<input type="text" class="form-control sk_input" id="alias" name="alias" maxlength="50" placeholder="经典套餐">
				</div>
				
				<div class="form-group">
					<label for="price">套餐价格</label>
					<input type="text" class="form-control sk_input" id="price" name="price" maxlength="50" placeholder="999">
				</div>
				
				<div class="form-group">
					<label for="content">套餐内容</label>
					<textarea class="form-control" rows="5" id="content" name="content"></textarea>
				</div>
				
				<div class="form-group">
					<label for="describe">套餐描述</label>
					<textarea class="form-control" rows="5" id="describe" name="describe"></textarea>
				</div>
				
				
			</div>
		</div>
		
		<!-- add right-->
		<div class="col-xs-6 sk_col" style="padding-left: 5px;">
			<div class="sk_option_back" style="border-top-color: #3C8DBC;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
				</div>
				
				<div class="form-group">
    				<label for="image0">套餐封面</label>
    				<input type="file" id="image0" name="image0">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;推荐750x250, jpg|png|bmp格式, 不超过100k</span>
				
				<div class="form-group">
    				<label for="image1">照片样本1</label>
    				<input type="file" id="image1" name="image1">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;推荐480x380, jpg|png|bmp格式, 不超过70k</span>
				
				<div class="form-group">
    				<label for="image2">照片样本2</label>
    				<input type="file" id="image2" name="image2">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;推荐480x380, jpg|png|bmp格式, 不超过70k</span>
				
				<div class="form-group">
    				<label for="image3">照片样本3</label>
    				<input type="file" id="image3" name="image3">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;推荐480x3800, jpg|png|bmp格式, 不超过70k</span>
				
				<div class="form-group">
					<label for="enable">套餐可用性</label>
					<select class="form-control sk_input" id="enable" name="enable">
						<option value="1">上线</option>
						<option value="0">下线</option>
					</select>
					<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;下线的节目内容将不会出现在应用程序中</span>
				</div>
				
				<div class="form-group">
					<a id="addLink" class="btn-primary sk_submitbtn" href="#"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;添加 add</a>
					<a id="back" class="btn-warning sk_submitbtn" href="/bendi/thinkmuyin/index.php/Admin/Package/index/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;放弃 back</a>
				</div>
				
			</div>
		</div>
		</form><!-- 表单结束 -->
		
	</div>
	
</div>

</body>
</html>