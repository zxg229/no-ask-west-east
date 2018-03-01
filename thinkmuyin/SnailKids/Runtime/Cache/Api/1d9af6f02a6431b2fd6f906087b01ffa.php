<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
		
		<form method="post" action="/snailkids.php/Api/Order/testPackageDo">
			
			<p>
				package:
				<select name="link_id">
					<?php if(is_array($packageList)): foreach($packageList as $key=>$p): ?><option value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; ?>
				</select>
			</p>
			
			<p>
				姓名：
				<input type="text" name="realname" />
			</p>
			
			<p>
				性别：
				<input type="radio" name="sex" value="1" checked="checked" />男
				<input type="radio" name="sex" value="0" />女
			</p>
			
			<p>
				手机号：
				<input type="text" name="phone" />
			</p>
			
			<p>
				拍摄地点：
				<input type="text" name="address" />
			</p>
			
			<p>
				地址详情：
				<input type="text" name="address_detail" />
			</p>
			
			<p>
				时间：
				<input type="text" name="order_time" />
			</p>
			
			<p>
				备注：
				<textarea type="text" name="note" ></textarea>
			</p>
			
			<p>
				<input type="submit" name="" value="submit"/>
			</p>
		
		</form>
		
	</body>
</html>