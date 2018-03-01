<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Package Edit</title>
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
			
			$("#saveLink").click(function(){		
				var name = $("#name").val();
				var alias = $("#alias").val();
				var price = $("#price").val();
				var content = $("#content").val();
				var describe = $("#describe").val();
				if(name==""||name==null||alias==""||alias==null||price==""||price==null||content==""||content==null||describe==""||describe==null){
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
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>套餐</b>&nbsp;&nbsp;<small style="color: #999999;">Package management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;Package&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			Edit
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		<!-- 表单开始 -->
		<form id="editForm" method="post" enctype="multipart/form-data" action="/bendi/thinkmuyin/index.php/Admin/Package/editDo/id/<?php echo ($id); ?>/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
		
		<!-- add left-->
		<div class="col-xs-6 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">编辑当前套餐</div>
					<div class="col-xs-6 sk_col text-right" id="alert"></div>
				</div>
				
				<div class="form-group">
					<label for="name">套餐名称</label>
					<input type="text" class="form-control sk_input" id="name" name="name" maxlength="50" placeholder="F1经典" value="<?php echo ($packageRow["name"]); ?>">
				</div>
				
				<div class="form-group">
					<label for="alias">套餐别名</label>
					<input type="text" class="form-control sk_input" id="alias" name="alias" maxlength="50" placeholder="经典套餐" value="<?php echo ($packageRow["alias"]); ?>">
				</div>
				
				<div class="form-group">
					<label for="price">套餐价格</label>
					<input type="text" class="form-control sk_input" id="price" name="price" maxlength="50" placeholder="999" value="<?php echo ($packageRow["price"]); ?>">
				</div>
				
				<div class="form-group">
					<label for="content">套餐内容</label>
					<textarea class="form-control" rows="5" id="content" name="content"><?php echo ($packageRow["content"]); ?></textarea>
				</div>
				
				<div class="form-group">
					<label for="describe">套餐描述</label>
					<textarea class="form-control" rows="5" id="describe" name="describe"><?php echo ($packageRow["describe"]); ?></textarea>
				</div>
				
				<div class="form-group">
    				<label for="image0">套餐封面</label>
    				<p><a href="<?php echo (getCompleteAddress($packageRow["cover_path"])); ?>" target="_blank">
						<img src="<?php echo (getCompleteAddress($packageRow["cover_path"])); ?>" style="width: auto; height: 100px; border-radius: 2px;">
					</a></p>
    				<input type="file" id="image0" name="image0">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;推荐750x250, jpg|png|bmp格式, 不超过100k</span>
				
				
			</div>
		</div>
		
		<!-- add right-->
		<div class="col-xs-6 sk_col" style="padding-left: 5px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
				</div>
				
				<div class="form-group">
    				<label for="image1">照片样本1</label>
    				<p><a href="<?php echo (getCompleteAddress($packageRow["imagePathGroup"]["0"])); ?>" target="_blank">
						<img src="<?php echo (getCompleteAddress($packageRow["imagePathGroup"]["0"])); ?>" style="width: auto; height: 100px; border-radius: 2px;">
					</a></p>
    				<input type="file" id="image1" name="image1">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;推荐480x380, jpg|png|bmp格式, 不超过70k</span>
				
				<div class="form-group">
    				<label for="image2">照片样本2</label>
    				<p><a href="<?php echo (getCompleteAddress($packageRow["imagePathGroup"]["1"])); ?>" target="_blank">
						<img src="<?php echo (getCompleteAddress($packageRow["imagePathGroup"]["1"])); ?>" style="width: auto; height: 100px; border-radius: 2px;">
					</a></p>
    				<input type="file" id="image2" name="image2">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;推荐480x380, jpg|png|bmp格式, 不超过70k</span>
				
				<div class="form-group">
    				<label for="image3">照片样本3</label>
    				<p><a href="<?php echo (getCompleteAddress($packageRow["imagePathGroup"]["2"])); ?>" target="_blank">
						<img src="<?php echo (getCompleteAddress($packageRow["imagePathGroup"]["2"])); ?>" style="width: auto; height: 100px; border-radius: 2px;">
					</a></p>
    				<input type="file" id="image3" name="image3">
  				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;推荐480x380, jpg|png|bmp格式, 不超过70k</span>
				
				<div class="form-group">
					<label for="enable">套餐可用性</label>
					<select class="form-control sk_input" id="enable" name="enable">
						<option value="1" <?php if($packageRow["enable"] == 1): ?>selected="selected"<?php endif; ?> >上线</option>
						<option value="0" <?php if($packageRow["enable"] == 0): ?>selected="selected"<?php endif; ?> >下线</option>
					</select>
					<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;下线的节目内容将不会出现在应用程序中</span>
				</div>
				
				<div style="margin-bottom: 15px;">
  					<p><b>添加时间：</b>&nbsp;&nbsp;<?php echo (date("m-d H:i",$packageRow["add_time"])); ?></p>
  					<p><b>编辑时间：</b>&nbsp;&nbsp;<?php echo (date("m-d H:i",$packageRow["edit_time"])); ?></p>
  					<p><b>管理员名：</b>&nbsp;&nbsp;<?php echo ($packageRow["admin_name"]); ?></p>
  				</div>
				
				<div class="form-group">
					<a id="saveLink" class="btn-success sk_submitbtn" href="#"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;保存 save</a>
					<a id="back" class="btn-warning sk_submitbtn" href="/bendi/thinkmuyin/index.php/Admin/Package/index/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;放弃 back</a>
				</div>
				
			</div>
		</div>
		</form><!-- 表单结束 -->
		
	</div>
	
</div>

</body>
</html>