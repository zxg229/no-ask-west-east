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
    	$(document).ready(function(){
			var form_option = $("#form_option").val();
			if(form_option == 'add'){
				$("#add_div").css('display','block');
			}
			else if(form_option == 'edit'){
				$("#edit_div").css('display','block');
			}
			
			$("#add_name").focus(function(){
    			$("#add_option_alert").html('');
    		});
    		$("#add_name_en").focus(function(){
    			$("#add_option_alert").html('');
    		});
    		$("#add_alias").focus(function(){
    			$("#add_option_alert").html('');
    		});
			
			$("#add_form").submit(function(){
				var add_name = $("#add_name").val();
				var add_name_en = $("#add_name_en").val();
				var add_alias = $("#add_alias").val();
				if(add_name == '' || add_name == null || add_name_en == '' || add_name_en == null || add_alias == '' || add_alias == null){
					$("#add_option_alert").html('<span style="color:#F39C12" class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;&nbsp;Incomplete information!');
					return false;
				}
			});
			
			$("#edit_name").focus(function(){
    			$("#edit_option_alert").html('');
    		});
    		$("#edit_name_en").focus(function(){
    			$("#edit_option_alert").html('');
    		});
    		$("#edit_alias").focus(function(){
    			$("#edit_option_alert").html('');
    		});
			
			$("#edit_form").submit(function(){
				var edit_name = $("#edit_name").val();
				var edit_name_en = $("#edit_name_en").val();
				var edit_alias = $("#edit_alias").val();
				if(edit_name == '' || edit_name == null || edit_name_en == '' || edit_name_en == null || edit_alias == '' || edit_alias == null){
					$("#edit_option_alert").html('<span style="color:#F39C12" class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;&nbsp;Incomplete information!');
					return false;
				}
			});
    	});
    </script>
</head>
<body>

<!-- 隐藏域 标识添加或编辑 -->
<input id="form_option" value="<?php echo ($option); ?>" style="display: none;">

<div class="container-fluid" style="padding: 15px;">
	<div class="row">
		<div class="col-xs-6 sk_col text-left" style="font-size: 14px;">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>省份管理</b>&nbsp;&nbsp;<small style="color: #999999;">Province management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-map-marker"></span>&nbsp;&nbsp;Area&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			Province
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		
		<!-- add -->
		<div class="col-xs-4 sk_col" id="add_div" style="padding-right: 10px;display: none;">
			<div class="sk_option_back" style="border-top-color: #3C8DBC;">
				<div style="font-size:12px;height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE;">
					<div style="float: left;">添加一个省份</div>
					<div id="add_option_alert" style="float: right;"></div>
				</div>
				<div style="clear: both;"></div>

				<form id="add_form" method="post" action="/snailkids.php/Admin/Area/provinceAddDo" style="margin: 0px; padding: 0px;">
					
					<div class="form-group" style="margin-top: 15px;">
    					<label for="add_name">省份名称</label>
    					<input type="text" class="form-control sk_input" id="add_name" name="name" maxlength="20" placeholder="province name, e.g. 吉林省">
  					</div>
  					
  					<div class="form-group">
    					<label for="add_name_en">省份英文名</label>
    					<input type="text" class="form-control sk_input" id="add_name_en" name="name_en" maxlength="20" placeholder="province english name, e.g. Jilin">
  					</div>
  					
  					<div class="form-group">
    					<label for="add_alias">省份别名</label>
    					<input type="text" class="form-control sk_input" id="add_alias" name="alias" maxlength="20" placeholder="province alias name, e.g. 吉林">
  					</div>
  					
  					<div class="form-group">
  						<label for="add_enable">数据可用性</label>
  						<select class="form-control sk_input" id="add_enable" name="enable">
  							<option value="1">上线&nbsp;Online</option>
  							<option value="0" selected="selected">下线&nbsp;Offline</option>
						</select>
						<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;下线的内容将不会出现在应用程序中</span>
  					</div>		
  					
 					<div class="sk_add_btn_gp">
 						<div class="sk_add_btn_icon">
 							<span class="glyphicon glyphicon-edit"></span>
 						</div>
 						<input class="sk_add_btn_ipt" type="submit" value="添加&nbsp;add" />
 					</div>
				</form>
			</div>
		</div>
		
		<!-- edit -->
		<div class="col-xs-4 sk_col" id="edit_div" style="padding-right: 10px;display: none;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				<div style="font-size:12px;height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE;">
					<div style="float: left;">编辑当前省份</div>
					<div id="edit_option_alert" style="float: right;"></div>
				</div>
				<div style="clear: both;"></div>
				
				<div>
				<form id="edit_form" method="post" action="/snailkids.php/Admin/Area/provinceEditDo/p/<?php echo ($p); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
					<input type="text" class="form-control sk_input hidden" id="edit_id" name="id" value="<?php echo ($data["id"]); ?>">
					<div class="form-group" style="margin-top: 15px;">
    					<label for="edit_name">省份名称</label>
    					<input type="text" class="form-control sk_input" id="edit_name" name="name" maxlength="20" placeholder="province name, e.g. 吉林省" value="<?php echo ($data["name"]); ?>">
  					</div>
  					
  					<div class="form-group">
    					<label for="edit_name_en">省份英文名</label>
    					<input type="text" class="form-control sk_input" id="edit_name_en" name="name_en" maxlength="20" placeholder="province english name, e.g. Jilin" value="<?php echo ($data["name_en"]); ?>">
  					</div>
  					
  					<div class="form-group">
    					<label for="edit_alias">省份别名</label>
    					<input type="text" class="form-control sk_input" id="edit_alias" name="alias" maxlength="20" placeholder="province alias name, e.g. 吉林" value="<?php echo ($data["alias"]); ?>">
  					</div>
  					
  					<div class="form-group">
  						<label for="edit_enable">数据可用性</label>
  						<select class="form-control sk_input" id="edit_enable" name="enable">
  							<option value="1" <?php if(($data["enable"] == 1)): ?>selected="selected"<?php endif; ?>>上线&nbsp;Online</option>
  							<option value="0" <?php if(($data["enable"] == 0)): ?>selected="selected"<?php endif; ?>>下线&nbsp;Offline</option>
						</select>
						<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;下线的内容将不会出现在应用程序中</span>
  					</div>
  					
  					<div class="form-group">
    					<label for="edit_edit_time">最近编辑时间</label>
    					<input type="text" class="form-control sk_input" id="edit_edit_time" name="edit_time" value="<?php echo (date("Y-m-d H:i:s",$data["edit_time"])); ?>" disabled>
  					</div>
  					
  					<div class="form-group">
    					<label for="edit_admin_realname">最近编辑管理员</label>
    					<input type="text" class="form-control sk_input" id="edit_admin_realname" name="edit_adminRealname" value="<?php echo ($adminRealname); ?>" disabled>
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
	 						<a class="sk_back_btn_ipt" href="/snailkids.php/Admin/Area/province/p/<?php echo ($p); ?>/order/<?php echo ($order); ?>">放弃&nbsp;back</a>
	 					</div>
	 					<div style="clear: both;"></div>
  					</div>
				</form>
				</div>
			</div>
		</div>
		
		<!-- list -->
		<div class="col-xs-8 sk_col" style="padding-left: 10px;">
			<div class="sk_option_back" style="border-top-color: #F39C12;">
				<div style="font-size:12px;height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE;">
					<div id="option_title" style="float: left;">省份列表</div>
					<div id="option_alert" style="float: right;"></div>
				</div>
				<div style="clear: both;"></div>
				<?php if(($count == 0)): ?><div style="margin-top: 15px; color: #AAAAAA;">No data...</div>
				<?php else: ?>
					<table class="table table-bordered" style="margin: 0px;">
	   					<caption style="margin-top: 5px; font-weight: bold; color: #333333;">当前省份表数据&nbsp;-&nbsp;<span class="sk_thead_oTitle"><?php echo ($orderTitle); ?></span></caption>
	   					<thead>
		      				<tr>
		         				<th>#</th>
		         				<?php if(is_array($thead)): foreach($thead as $k=>$v): ?><th><?php echo ($v); ?></th><?php endforeach; endif; ?>
		         				<th>Option</th>
		      				</tr>
	   					</thead>
	   					<tbody>
					    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	   							<td><?php echo ($i); ?>.</td>
	   							<td><?php echo ($vo["id"]); ?></td>
	   							<td><?php echo ($vo["name"]); ?></td>
	   							<?php if($vo["enable"] == 1): ?><td><span class="glyphicon glyphicon-circle-arrow-up" style="color: green;"></span>&nbsp;&nbsp;上线</td>
	   							<?php else: ?>
	   								<td><span class="glyphicon glyphicon-circle-arrow-down" style="color: red;"></span>&nbsp;&nbsp;下线</td><?php endif; ?>
	   							<td><?php echo (date("m-d H:i",$vo["edit_time"])); ?></td>
	   							<td><a href="/snailkids.php/Admin/Area/provinceEdit/id/<?php echo ($vo["id"]); ?>/p/<?php echo ($pageNow); ?>/order/<?php echo ($order); ?>" style="" class="sk_table_ooption"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;edit</a></td>
					    	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	   					</tbody>
					</table>
					
					<nav style="margin-top: 10px;" class="text-right">
  						<ul class="pagination pagination-sm" style="margin: 0px;">
						<?php if(($pageNow == 1)): ?><li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
						<?php else: ?>
							<li><a href="/snailkids.php/Admin/Area/province/p/<?php echo ($pageNow-1); ?>/order/<?php echo ($order); ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?php endif; ?>
					    <?php $__FOR_START_28780__=1;$__FOR_END_28780__=$totalPage;for($i=$__FOR_START_28780__;$i <= $__FOR_END_28780__;$i+=1){ if(($i == $pageNow)): ?><li class="active"><a href="/snailkids.php/Admin/Area/province/p/<?php echo ($i); ?>/order/<?php echo ($order); ?>"><?php echo ($i); ?></a></li>
					    	<?php else: ?>
					    		<li><a href="/snailkids.php/Admin/Area/province/p/<?php echo ($i); ?>/order/<?php echo ($order); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>
						<?php if(($pageNow == $totalPage)): ?><li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
						<?php else: ?>
							<li><a href="/snailkids.php/Admin/Area/province/p/<?php echo ($pageNow+1); ?>/order/<?php echo ($order); ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?php endif; ?>
  						</ul>
					</nav><?php endif; ?>
			</div>
		</div>
		
	</div>
	
</div>

</body>
</html>