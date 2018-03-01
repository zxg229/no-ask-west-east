<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Trailer Edit</title>
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
			$("#standard_video_path").focus(function(){
				$("#alert").html('');
			});
			$("#high_video_path").focus(function(){
				$("#alert").html('');
			});
			$("#saveTrailer").click(function(){
				var name = $("#name").val();
				var introduce = $("#introduce").val();
				var standard_video_path = $("#standard_video_path").val();
				var high_video_path = $("#high_video_path").val();
				if(name==""||name==null||introduce==""||introduce==null||standard_video_path==""||standard_video_path==null||high_video_path==""||high_video_path==null){
					$("#alert").html('<span style="color:#F39C12" class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;&nbsp;Incomplete information!');
				}
				else{
					$("#editForm").submit();
				}
			});
			
			$("#svideoPreviewShow").click(function(){
				$("#svideoPreview").show();
			});
			$("#hvideoPreviewShow").click(function(){
				$("#hvideoPreview").show();
			});
			
    	});
    </script>
</head>
<body>

<div class="container-fluid" style="padding: 15px;">
	<div class="row">
		<div class="col-xs-6 sk_col text-left" style="font-size: 14px;">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>宣传片</b>&nbsp;&nbsp;<small style="color: #999999;">Trailer management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon glyphicon-bullhorn"></span>&nbsp;&nbsp;Trailer&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			Edit
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		<!-- 表单开始 -->
		<form id="editForm" method="post" enctype="multipart/form-data" action="/snailkids.php/Admin/Trailer/editDo/id/<?php echo ($id); ?>/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
		
		<!-- add left-->
		<div class="col-xs-6 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">编辑当前宣传片</div>
					<div class="col-xs-6 sk_col text-right" id="alert"></div>
				</div>
				
				<div class="form-group">
					<label for="name">宣传片名称</label>
					<input type="text" class="form-control sk_input" id="name" name="name" maxlength="50" placeholder="小蜗牛传媒第一次媒体宣传" value="<?php echo ($trailerData["name"]); ?>">
				</div>
				
				<div class="form-group">
					<label for="introduce">宣传片简介</label>
					<textarea class="form-control" rows="5" id="introduce" name="introduce" value="<?php echo ($trailerData["introduce"]); ?>"><?php echo ($trailerData["introduce"]); ?></textarea>
				</div>
				
				<div class="form-group">
					<label for="locally">视频文件存放位置</label>
					<select class="form-control sk_input" id="locally" name="locally">
						<option value="0" <?php if($trailerData["locally"] == 0): ?>selected="selected"<?php endif; ?> >第三方支持</option>
						<option value="1" <?php if($trailerData["locally"] == 1): ?>selected="selected"<?php endif; ?> >本地服务器</option>
					</select>
					<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;不同的存放位置 决定下面文件地址填写的差别</span>
				</div>
				
				<div class="form-group">
					<label for="standard_video_path">标清视频地址</label>
					<input type="text" class="form-control sk_input" id="standard_video_path" name="standard_video_path" maxlength="200" value="<?php echo ($trailerData["standard_video_path"]); ?>">
				</div>
				<span class="help-block sk_help_block">
					<span class="glyphicon glyphicon-info-sign"></span><br />
					服务器本地存放视频文件时请确保文件真实存在<br />
					地址格式范例：SnailKids/Public/Upload/Trailer/SVideo/20160612_23S.mp4<br />
					第三方存放文件时范例：http://v.youku.com/storage/235667/20160612_23S.mp4
				</span>
				
				<div class="form-group">
					<label for="high_video_path">高清视频地址</label>
					<input type="text" class="form-control sk_input" id="high_video_path" name="high_video_path" maxlength="200" value="<?php echo ($trailerData["high_video_path"]); ?>">
				</div>
				<span class="help-block sk_help_block">
					<span class="glyphicon glyphicon-info-sign"></span><br />
					服务器本地存放视频文件时请确保文件真实存在<br />
					地址格式范例：SnailKids/Public/Upload/Trailer/HVideo/20160612_23H.mp4<br />
					第三方存放文件时范例：http://v.youku.com/storage/235667/20160612_23H.mp4
				</span>
				
				<div class="form-group">
					<label for="enable">宣传片可用性</label>
					<select class="form-control sk_input" id="enable" name="enable">
						<option value="0" <?php if($trailerData["enable"] == 0): ?>selected="selected"<?php endif; ?> >下线</option>
						<option value="1" <?php if($trailerData["enable"] == 1): ?>selected="selected"<?php endif; ?> >上线</option>
					</select>
					<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;下线的节目内容将不会出现在应用程序中</span>
				</div>

			</div>
		</div>
		
		
		<!-- add right-->
		<div class="col-xs-6 sk_col" style="padding-left: 5px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
				</div>
				
				<div class="form-group">
					<label for="thumb_path">宣传片缩略图</label>
					<p><a href="<?php echo (getCompleteAddress($trailerData["thumb_path"])); ?>" target="_blank">
						<img src="<?php echo (getCompleteAddress($trailerData["thumb_path"])); ?>" style="width: auto; height: 100px; border-radius: 2px;">
					</a></p>
					<input type="file" id="thumb_path" name="thumb_path">
				</div>
				<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;支持jpg、png、bmp格式图像 文件不得超过1024k</span>
  			
  				<div style="margin-bottom: 15px;">
  					<p><b>添加时间：</b>&nbsp;&nbsp;<?php echo (date("m-d H:i",$trailerData["add_time"])); ?></p>
  					<p><b>编辑时间：</b>&nbsp;&nbsp;<?php echo (date("m-d H:i",$trailerData["edit_time"])); ?></p>
  					<p><b>管理员名：</b>&nbsp;&nbsp;<?php echo ($trailerData["admin_name"]); ?></p>
  				</div>
  			
  				<div class="form-group">
					<a id="saveTrailer" class="btn-success sk_submitbtn" href="#"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;保存 save</a>
					<a id="back" class="btn-warning sk_submitbtn" href="/snailkids.php/Admin/Trailer/index/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;放弃 back</a>
				</div>
				
				<div class="form-group">
					<label for="svideoPreview"><a href="#" id="svideoPreviewShow"><span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;播放已存标清视频</a></label>
					<video id="svideoPreview" width="100%" style="display: none;" src="<?php echo ($trailerData["current_standard_video_path"]); ?>" controls="controls" preload="none">
						your browser does not support the video tag
					</video>
				</div>
				
				<div class="form-group">
					<label for="hvideoPreview"><a href="#" id="hvideoPreviewShow"><span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;播放已存高清视频</a></label>
					<video id="hvideoPreview" width="100%" style="display: none;" src="<?php echo ($trailerData["current_high_video_path"]); ?>" controls="controls" preload="none">
						your browser does not support the video tag
					</video>
				</div>

				
			</div>
		</div>
		
		</form><!-- 表单结束 -->
		
	</div>
	
</div>

</body>
</html>