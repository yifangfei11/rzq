<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>ECSHOP 管理中心 - <?php echo $_page_title;?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Admin/styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $_address_name;?>"><?php echo $_btn_name;?> </a></span>
    <span class="action-span1"><a href="__GROUP__">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品列表 </span>
    <div style="clear:both"></div>
</h1>


<!-- 列表 -->
<div class="list-div" id="listDiv">
<form method="POST" action="/index.php/Admin/Goods/goods_number/id/34.html">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <!-- 循环输出属性 -->
            <?php foreach ($gaData as $k => $v): ?>
            	<th><?php echo $k; ?></th>
            <?php endforeach; ?>
            <th width="120">库存量</th>
			<th width="60">操作</th>
        </tr>
        <?php if($gnData): ?>
	        <?php foreach ($gnData as $k0 => $v0): ?>
	        <tr class="tron">
	        	<?php  $gaCount = count($gaData); foreach ($gaData as $k => $v): ?>
	        		<td>
	        			<select name="goods_attr_id[]">
	        				<option value="">请选择</option>
	        				<?php foreach ($v as $k1 => $v1): $_attr = explode(',', $v0['goods_attr_id']); if(in_array($v1['id'], $_attr)) $select = 'selected="selected"'; else $select = ''; ?>
	        					<option <?php echo $select; ?> value="<?php echo $v1['id']; ?>"><?php echo $v1['attr_value']; ?></option>
	        				<?php endforeach; ?>
	        			</select>
	        		</td>
	        	<?php endforeach; ?>
	        	<td><input type="text" name="goods_number[]" value="<?php echo $v0['goods_number']; ?>" /></td>
	        	<td><input onclick="addNewTr(this);" type="button" value="<?php echo $k0==0?'+':'-'; ?>" /></td>
	        </tr>
	        <?php endforeach; ?>
	    <?php else: ?>
	    	<tr class="tron">
	        	<?php  $gaCount = count($gaData); foreach ($gaData as $k => $v): ?>
	        		<td>
	        			<select name="goods_attr_id[]">
	        				<option value="">请选择</option>
	        				<?php foreach ($v as $k1 => $v1): ?>
	        					<option value="<?php echo $v1['id']; ?>"><?php echo $v1['attr_value']; ?></option>
	        				<?php endforeach; ?>
	        			</select>
	        		</td>
	        	<?php endforeach; ?>
	        	<td><input type="text" name="goods_number[]" value="" /></td>
	        	<td><input onclick="addNewTr(this);" type="button" value="+" /></td>
	        </tr>
	    <?php endif; ?>
        <tr id="submit">
        	<td align="center" colspan="<?php echo $gaCount+2; ?>"><input type="submit" value="提交" /></td>
        </tr>
	</table>
</form>
</div>

<script>
function addNewTr(btn)
{
	var tr = $(btn).parent().parent();
	if($(btn).val() == "+")
	{
		var newTr = tr.clone();
		newTr.find(":button").val("-");
		$("#submit").before(newTr);
	}
	else
		tr.remove();
}
</script>

<script src="/Public/Admin/Js/tron.js"></script>
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>

<script type="text/javascript" src="/Public/Admin/Js/jquery.js"></script>