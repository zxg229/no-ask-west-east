<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Order Edit</title>
    <!--<link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){			
			
			$("#saveLink").click(function(){		
				$("#editForm").submit();
			});
			
    	});
    </script>
</head>
<body>

<div class="container-fluid" style="padding: 15px;">
	<div class="row">
		<div class="col-xs-6 sk_col text-left" style="font-size: 14px;">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;&nbsp;<b>订单</b>&nbsp;&nbsp;<small style="color: #999999;">Order management</small>
		</div>
		<div class="col-xs-6 sk_col text-right" style="color: #444444;">
			<span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			<span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Order&nbsp;&nbsp;&rsaquo;&nbsp;&nbsp;
			Edit
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		<!-- 表单开始 -->
		<form id="editForm" method="post" action="/snailkids.php/Admin/Order/editDo/id/<?php echo ($id); ?>/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" style="margin: 0px; padding: 0px;">
		
		<!-- add left-->
		<div class="col-xs-6 sk_col" style="padding-right: 5px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
					<div class="col-xs-6 sk_col">审核当前订单</div>
					<div class="col-xs-6 sk_col text-right" id="alert"></div>
				</div>
				
				<div style="margin-bottom: 15px; border-bottom: 1px dotted #EEEEEE;">
  					<p><b>订单ID：</b>&nbsp;&nbsp;<?php echo ($orderRow["id"]); ?></p>
  					<p><b>客户名称：</b>&nbsp;&nbsp;<?php echo ($orderRow["realname"]); ?></p>
  					<p><b>客户性别：</b>&nbsp;&nbsp;
  						<?php switch($orderRow["sex"]): case "0": ?>女<?php break;?>
  							<?php case "1": ?>男<?php break; endswitch;?>
  					</p>
  					<p><b>客户电话：</b>&nbsp;&nbsp;<?php echo ($orderRow["phone"]); ?></p>
  					<p><b>客户地址：</b>&nbsp;&nbsp;<?php echo ($orderRow["address"]); ?></p>
  					<p><b>详细地址：</b>&nbsp;&nbsp;<?php echo ($orderRow["address_detail"]); ?></p>
  					<p><b>拍摄时间：</b>&nbsp;&nbsp;<?php echo ($orderRow["order_time"]); ?></p>
  					<p><b>备注信息：</b>&nbsp;&nbsp;<?php echo ($orderRow["note"]); ?></p>
  					<p><b>订单类型：</b>&nbsp;&nbsp;
  						<?php switch($orderRow["type"]): case "0": ?>订制预约<?php break;?>
  							<?php case "1": ?>套餐预约<?php break; endswitch;?>
  					</p>
  				</div>
  				
  				<div style="margin-bottom: 15px;">
  					<p><b>订单产生时间：</b>&nbsp;&nbsp;<?php echo (date("m-d H:i",$orderRow["add_time"])); ?></p>
  					<p><b>最近修改时间：</b>&nbsp;&nbsp;<?php echo (date("m-d H:i",$orderRow["edit_time"])); ?></p>
  					<p><b>修改管理员名：</b>&nbsp;&nbsp;<?php echo ($orderRow["admin_name"]); ?></p>
  				</div>
  				
				
			</div>
		</div>
		
		<!-- add right-->
		<div class="col-xs-6 sk_col" style="padding-left: 5px;">
			<div class="sk_option_back" style="border-top-color: #00A65A;">
				
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE; margin-bottom: 15px;">
				</div>
				
				<?php if($orderRow["type"] == 0): ?><div style="margin-bottom: 15px; border-bottom: 1px dotted #EEEEEE;">
  					<p><b>拍摄阶段：</b>&nbsp;&nbsp;<?php echo ($orderDetailRow["phase_name"]); ?></p>
  					<p><b>拍摄主题：</b>&nbsp;&nbsp;<?php echo ($orderDetailRow["theme_name"]); ?></p>
  					<p><b>拍摄时长：</b>&nbsp;&nbsp;<?php echo ($orderDetailRow["duration"]); ?></p>
  					<p><b>是否自撰稿：</b>&nbsp;&nbsp;
  						<?php switch($orderDetailRow["writting"]): case "0": ?>否<?php break;?>
  							<?php case "1": ?>是<?php break; endswitch;?>
  					</p>
  					<p><b>是否带妆：</b>&nbsp;&nbsp;
  						<?php switch($orderDetailRow["makeup"]): case "0": ?>否<?php break;?>
  							<?php case "1": ?>是<?php break; endswitch;?>
  					</p>
  					<p><b>是否免灯：</b>&nbsp;&nbsp;
  						<?php switch($orderDetailRow["light"]): case "0": ?>否<?php break;?>
  							<?php case "1": ?>是<?php break; endswitch;?>
  					</p>
  					<p><b>是否需要额外道具：</b>&nbsp;&nbsp;
  						<?php switch($orderDetailRow["prop"]): case "0": ?>否<?php break;?>
  							<?php case "1": ?>是<?php break; endswitch;?>
  					</p>
  					<p><b>后期呈现效果是否有特殊要求：</b>&nbsp;&nbsp;
  						<?php switch($orderDetailRow["request"]): case "0": ?>否<?php break;?>
  							<?php case "1": ?>是<?php break; endswitch;?>
  					</p>
  				</div><?php endif; ?>
				
				<?php if($orderRow["type"] == 1): ?><div style="margin-bottom: 15px; border-bottom: 1px dotted #EEEEEE;">
					<p><b>套餐选择：</b>&nbsp;&nbsp;<?php echo ($packageRow["name"]); ?> - ￥<?php echo ($packageRow["price"]); ?> - <?php echo ($packageRow["alias"]); ?></p>
					</div><?php endif; ?>
				
				<div class="form-group">
					<label for="state">订单状态</label>
					<select class="form-control sk_input" id="state" name="state">
						<option value="0" <?php if($orderRow["state"] == 0): ?>selected="selected"<?php endif; ?> >已作废</option>
						<option value="1" <?php if($orderRow["state"] == 1): ?>selected="selected"<?php endif; ?> >已提交</option>
						<option value="2" <?php if($orderRow["state"] == 2): ?>selected="selected"<?php endif; ?> >已联络</option>
						<option value="3" <?php if($orderRow["state"] == 3): ?>selected="selected"<?php endif; ?> >已完成</option>
					</select>
					<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;请勿随意变更订单状态 您的操作将被记录在系统中</span>
				</div>
				
				<div class="form-group">
					<label for="pay">支付状态</label>
					<select class="form-control sk_input" id="pay" name="pay">
						<option value="0" <?php if($orderRow["pay"] == 0): ?>selected="selected"<?php endif; ?> >未支付</option>
						<option value="1" <?php if($orderRow["pay"] == 1): ?>selected="selected"<?php endif; ?> >已支付</option>
					</select>
					<span class="help-block sk_help_block"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;请勿随意变更支付状态 您的操作将被记录在系统中</span>
				</div>
				
				<div class="form-group">
					<a id="saveLink" class="btn-success sk_submitbtn" href="#"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;保存 save</a>
					<a id="back" class="btn-warning sk_submitbtn" href="/snailkids.php/Admin/Order/index/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><span class="glyphicon glyphicon-share"></span>&nbsp;&nbsp;放弃 back</a>
				</div>
				
			</div>
		</div>
		</form><!-- 表单结束 -->
		
	</div>
	
</div>

</body>
</html>