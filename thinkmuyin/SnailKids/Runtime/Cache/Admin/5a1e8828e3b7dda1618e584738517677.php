<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Video Option</title>
    <!--<link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){	
    		
    		
//  		$("#commentLink").click(function(){
//  			$("#optionType").val("comment");
//  			var comment = $("#comment").val();
//  			alert(comment);
//  		});
	
			$("#praiseLink").click(function(){
				$("#optionType").val("praise");
				$("#optionForm").submit();
			});
			
			$("#commentLink").click(function(){
				$("#optionType").val("comment");
				var comment = $("#comment").val();
				if(comment == "" || comment == null){
					$("#alert").html('<span style="color:#F39C12" class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;&nbsp;Incomplete information!');
				}
				else{
					$("#optionForm").submit();
				}
			});
			
    	});
    </script>
</head>
<body>

<div class="container-fluid" style="padding: 15px;">
	<div class="row">
		<div class="col-xs-6 sk_col text-left" style="font-size: 14px;">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>视频样片</b>&nbsp;&nbsp;<small style="color: #999999;">Video management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-facetime-video"></span>&nbsp;&nbsp;Video&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			Option
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		
		<!-- add left-->
		<div class="col-xs-6 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #D81B60;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">对视频的用户操作</div>
					<div class="col-xs-6 sk_col text-right" id="alert"></div>
				</div>
				
				<div style="margin-bottom: 15px;">
  					<p><b>视频标题：</b>&nbsp;&nbsp;<?php echo ($videoData["title"]); ?></p>
  					<p><b>播放次数：</b>&nbsp;&nbsp;<?php echo ($videoData["play_num"]); ?></p>
  					<p><b>点赞次数：</b>&nbsp;&nbsp;<?php echo ($videoData["praise_num"]); ?></p>
  					<p><b>评论次数：</b>&nbsp;&nbsp;<?php echo ($videoData["comment_num"]); ?></p>
  				</div>
  				
  				<!-- 表单开始 -->
				<form id="optionForm" method="post" action="/snailkids.php/Admin/Video/optionDo/id/<?php echo ($id); ?>/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
  				
  				<input id="optionType" name="optionType" type="hidden" value="" />
  				
  				<div class="form-group">
					<label for="user_id">操作用户选择</label>
					<select class="form-control sk_input" id="user_id" name="user_id">
						<?php if(is_array($userData)): foreach($userData as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["username"]); ?>&nbsp;-&nbsp;<?php echo ($v["nickname"]); ?></option><?php endforeach; endif; ?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="">点赞操作</label><br />
					<a id="praiseLink" class="btn-danger sk_submitbtn" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;&nbsp;点赞 praise</a>
					<a id="back" class="btn-warning sk_submitbtn" href="/snailkids.php/Admin/Video/index/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;放弃 back</a>
				</div>
				
				<div class="form-group">
					<label for="comment">发布评论</label>
					<textarea class="form-control" rows="5" id="comment" name="comment"></textarea><br />
					<a id="commentLink" class="btn-info sk_submitbtn" href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;评论 comment</a>
				</div>
				</form><!-- 表单结束 -->
				
			</div>
		</div>
		
		
	</div>
	
</div>

</body>
</html>