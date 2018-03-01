<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Order</title>
    <!--<link href="<?php echo (ADMIN_PUBLIC_CSS); ?>bootstrap.min.css" rel="stylesheet" type="text/css">-->
    <link rel="stylesheet" type="text/css" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    <link href="<?php echo (ADMIN_PUBLIC_CSS); ?>sk_common.css" rel="stylesheet">
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>jquery-2.2.4.min.js"></script>
    <script src="<?php echo (ADMIN_PUBLIC_JS); ?>bootstrap.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){			
	
			$("#whereSelect").change(function(){
				var href = "/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/" + $("#whereSelect").val() + "/order/id_desc";
				location.href = href;
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
			List
		</div>
	</div>
	
	<div class="row" style="margin-top: 15px;">
		
		<!-- list -->
		<div class="col-xs-12 sk_col">
			<div class="sk_option_back" style="border-top-color: #F39C12;">
				<div class="row" style="height:30px; line-height:30px;border-bottom: 1px dotted #EEEEEE;">
					<div class="col-xs-6 sk_col">订单列表</div>
					<div class="col-xs-6 sk_col text-right">
					</div>
				</div>
				<div style="clear: both;"></div>
				
				<!-- 表格描述 -->
				<div class="row" style="margin-top: 5px; padding: 10px 0px;">
					<div class="col-xs-6 sk_col" style="font-weight: bold; color: #333333;">
						当前订单表数据
						<?php if($count > 0): ?>&nbsp;-&nbsp;<span class="sk_thead_oTitle"><?php echo ($orders["$order"]["tag"]); ?></span>
							&nbsp;-&nbsp;共<?php echo ($count); ?>条数据</span><?php endif; ?>
					</div>
					<div class="col-xs-6 sk_col">
						<select id="whereSelect" class="form-control sk_input pull-right" style="width: auto; height: 25px; line-height: 25px;">
						<?php if(is_array($wheres)): foreach($wheres as $k=>$v): ?><option <?php if($k == $where): ?>selected="selected"<?php endif; ?> value="<?php echo ($k); ?>"><?php echo ($v["tag"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				
				<?php if($count == 0): ?><div style="margin-top: 15px; color: #AAAAAA;">No data...</div>
				<?php else: ?>
					<!-- 显示table数据 -->
					<table class="table table-bordered" style="margin: 0px;">
						<!-- 表格头 -->
						<thead>
		      				<tr>
		         				<th>#</th>
		         				<th>
		         					<span class="sk_thead_title">ID</span>
		         					<?php switch($order): case "id": ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/id_desc" class="sk_thead_link_cur"><span class="glyphicon glyphicon-sort-by-attributes"></span><?php break;?>
		         						<?php case "id_desc": ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/id" class="sk_thead_link_cur"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span><?php break;?>
		         						<?php default: ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/id" class="sk_thead_link"><span class="glyphicon glyphicon-sort"></span></a><?php endswitch;?>
		         				</th>
		         				<th>联系人姓名</th>
		         				<th>
		         					<span class="sk_thead_title">预约时间</span>
		         					<?php switch($order): case "order_time": ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/order_time_desc" class="sk_thead_link_cur"><span class="glyphicon glyphicon-sort-by-attributes"></span><?php break;?>
		         						<?php case "order_time_desc": ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/order_time" class="sk_thead_link_cur"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span><?php break;?>
		         						<?php default: ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/order_time" class="sk_thead_link"><span class="glyphicon glyphicon-sort"></span></a><?php endswitch;?>
		         				</th>
		         				<th>订单类型</th>
		         				<th>订单状态</th>
		         				<th>支付</th>
		         				<th>
		         					<span class="sk_thead_title">产生时间</span>
		         					<?php switch($order): case "add_time": ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/add_time_desc" class="sk_thead_link_cur"><span class="glyphicon glyphicon-sort-by-attributes"></span><?php break;?>
		         						<?php case "add_time_desc": ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/add_time" class="sk_thead_link_cur"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span><?php break;?>
		         						<?php default: ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/add_time" class="sk_thead_link"><span class="glyphicon glyphicon-sort"></span></a><?php endswitch;?>
		         				</th>
		         				<th>
		         					<span class="sk_thead_title">最近修改时间</span>
		         					<?php switch($order): case "edit_time": ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/edit_time_desc" class="sk_thead_link_cur"><span class="glyphicon glyphicon-sort-by-attributes"></span><?php break;?>
		         						<?php case "edit_time_desc": ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/edit_time" class="sk_thead_link_cur"><span class="glyphicon glyphicon-sort-by-attributes-alt"></span><?php break;?>
		         						<?php default: ?><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/1/where/<?php echo ($where); ?>/order/edit_time" class="sk_thead_link"><span class="glyphicon glyphicon-sort"></span></a><?php endswitch;?>
		         				</th>
		         				<th>修改管理员</th>
		         				<th>选项	</th>
		      				</tr>
	   					</thead>
	   					
	   					<!-- 表格体 -->
	   					<tbody>
	   						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
	   								<td><?php echo ($i); ?>.</td>
	   								<td><?php echo ($v["id"]); ?></td>
	   								<td><?php echo ($v["realname"]); ?></td>
	   								<td><?php echo ($v["order_time"]); ?></td>
	   								<td>
	   									<?php switch($v["type"]): case "0": ?>订制预约订单<?php break;?>
	   										<?php case "1": ?>套餐预约订单<?php break; endswitch;?>
	   								</td>
	   								<td>
	   									<?php switch($v["state"]): case "0": ?><span class="glyphicon glyphicon-remove-sign" style="color:red;"></span>&nbsp;&nbsp;已作废<?php break;?>
	   										<?php case "1": ?><span class="glyphicon glyphicon-info-sign" style="color:blue;"></span>&nbsp;&nbsp;已提交<?php break;?>
	   										<?php case "2": ?><span class="glyphicon glyphicon-question-sign" style="color:yellow;"></span>&nbsp;&nbsp;已联络<?php break;?>
	   										<?php case "3": ?><span class="glyphicon glyphicon-ok-sign" style="color:green;"></span>&nbsp;&nbsp;已完成<?php break; endswitch;?>
	   								</td>
	   								<td>
	   									<?php switch($v["pay"]): case "0": ?><span class="glyphicon glyphicon-remove" style="color: red;"></span>&nbsp;&nbsp;未支付<?php break;?>
	   										<?php case "1": ?><span class="glyphicon glyphicon-ok" style="color: green;"></span>&nbsp;&nbsp;已支付<?php break; endswitch;?>
	   								</td>
	   								<td><?php echo (date("m-d H:i",$v["add_time"])); ?></td>
	   								<td><?php echo (date("m-d H:i",$v["edit_time"])); ?></td>
	   								<td><?php echo ($v["admin_realname"]); ?></td>
	   								<td><a href="/bendi/thinkmuyin/index.php/Admin/Order/edit/id/<?php echo ($v["id"]); ?>/p/<?php echo ($pageNow); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" class="sk_table_ooption"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;审核</a></td>
	   							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	   					</tbody>
	   				</table>
	   				
	   				<nav style="margin-top: 10px;" class="text-right">
  						<ul class="pagination pagination-sm" style="margin: 0px;">
						<?php if(($pageNow == 1)): ?><li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
						<?php else: ?>
							<li><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/<?php echo ($pageNow-1); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?php endif; ?>
					    <?php $__FOR_START_25106__=1;$__FOR_END_25106__=$pageCount;for($i=$__FOR_START_25106__;$i <= $__FOR_END_25106__;$i+=1){ if(($i == $pageNow)): ?><li class="active"><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/<?php echo ($i); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><?php echo ($i); ?></a></li>
					    	<?php else: ?>
					    		<li><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/<?php echo ($i); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>"><?php echo ($i); ?></a></li><?php endif; } ?>
						<?php if(($pageNow == $pageCount)): ?><li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
						<?php else: ?>
							<li><a href="/bendi/thinkmuyin/index.php/Admin/Order/index/p/<?php echo ($pageNow+1); ?>/where/<?php echo ($where); ?>/order/<?php echo ($order); ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?php endif; ?>
  						</ul>
					</nav><?php endif; ?>

			</div>
		</div>
		
	</div>
	
</div>

</body>
</html>