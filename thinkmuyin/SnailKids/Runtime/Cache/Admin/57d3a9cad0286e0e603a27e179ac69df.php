<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Photo Add</title>
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
			$("#introduce").focus(function(){
				$("#alert").html('');
			});
			$("#photo1").focus(function(){
				$("#alert").html('');
			});
			$("#photo2").focus(function(){
				$("#alert").html('');
			});
			$("#photo3").focus(function(){
				$("#alert").html('');
			});
			$("#photo4").focus(function(){
				$("#alert").html('');
			});
			$("#photo5").focus(function(){
				$("#alert").html('');
			});
			$("#photo6").focus(function(){
				$("#alert").html('');
			});
			
			$("#addPhoto").click(function(){		
				var name = $("#name").val();
				var introduce = $("#introduce").val();
				var image1 = $("#photo1").val();
				var image2 = $("#photo2").val();
				var image3 = $("#photo3").val();
				var image4 = $("#photo4").val();
				var image5 = $("#photo5").val();
				var image6 = $("#photo6").val();
				if(name==""||name==null||introduce==""||introduce==null||image1==""||image1==null||image2==""||image2==null||image3==""||image3==null||image4==""||image4==null||image5==""||image5==null||image6==""||image6==null){
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
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>照片组</b>&nbsp;&nbsp;<small style="color: #999999;">Photo management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Photo&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			Add
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		<!-- 表单开始 -->
		<form id="addForm" method="post" enctype="multipart/form-data" action="/thinkmuyin/index.php/Admin/Photo/addDo/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
		
		<!-- add left-->
		<div class="col-xs-6 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #3C8DBC;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">添加一个照片组</div>
					<div class="col-xs-6 sk_col text-right" id="alert"></div>
				</div>
				
				<div class="form-group">
					<label for="name">照片组名称</label>
					<input type="text" class="form-control sk_input" id="name" name="name" maxlength="50" placeholder="小蜗牛传媒第一次集体合影">
				</div>
				
				<div class="form-group">
					<label for="introduce">照片组介绍</label>
					<textarea class="form-control" rows="5" id="introduce" name="introduce"></textarea>
				</div>
				
				<div class="form-group">
    				<label for="photo1">照片1</label>
    				<input type="file" id="photo1" name="photo1">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;支持jpg、png、bmp格式图像 500x380 不超过70k</span>
				
				<div class="form-group">
    				<label for="photo2">照片2</label>
    				<input type="file" id="photo2" name="photo2">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;支持jpg、png、bmp格式图像 500x380 不超过70k</span>
				
				<div class="form-group">
    				<label for="photo3">照片3</label>
    				<input type="file" id="photo3" name="photo3">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;支持jpg、png、bmp格式图像 500x380 不超过70k</span>
				
				

			</div>
		</div>
		
		<!-- add right-->
		<div class="col-xs-6 sk_col" style="padding-left: 5px;">
			<div class="sk_option_back" style="border-top-color: #3C8DBC;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
				</div>
				
				<div class="form-group">
    				<label for="photo4">照片4</label>
    				<input type="file" id="photo4" name="photo4">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;支持jpg、png、bmp格式图像 500x380 不超过70k</span>
				
				<div class="form-group">
    				<label for="photo5">照片5</label>
    				<input type="file" id="photo5" name="photo5">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;支持jpg、png、bmp格式图像 500x380 不超过70k</span>
				
				<div class="form-group">
    				<label for="photo6">照片6</label>
    				<input type="file" id="photo6" name="photo6">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;支持jpg、png、bmp格式图像 500x380 不超过70k</span>
				
				<div class="form-group">
					<label for="enable">照片组可用性</label>
					<select class="form-control sk_input" id="enable" name="enable">
						<option value="1">上线</option>
						<option value="0">下线</option>
					</select>
					<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;下线的节目内容将不会出现在应用程序中</span>
				</div>
				
				<div class="form-group">
					<a id="addPhoto" class="btn-primary sk_submitbtn" href="#"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;添加 add</a>
					<a id="back" class="btn-warning sk_submitbtn" href="/thinkmuyin/index.php/Admin/Photo/index/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;放弃 back</a>
				</div>
				
			</div>
		</div>
		</form><!-- 表单结束 -->
		
	</div>
	
</div>

</body>
</html>