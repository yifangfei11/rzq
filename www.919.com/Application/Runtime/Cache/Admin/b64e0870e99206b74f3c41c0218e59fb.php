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


<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Admin/Admin/edit/id/11.html" enctype="multipart/form-data" >
    	<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
        	<?php if($data['id'] > 1): ?>
        	<tr>
                <td class="label">角色列表：</td>
                <td>
                    <?php foreach ($roleData as $k => $v): if(strpos(','.$roleId.',', ','.$v['id'].',') !==FALSE) $check = 'checked="checked"'; else $check = ''; ?>
                    	<input <?php echo $check; ?> type="checkbox" name="role_id[]" value="<?php echo $v['id']; ?>" />
                    	<?php echo $v['role_name']; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td class="label">用户名：</td>
                <td>
                    <input  type="text" name="account" value="<?php echo $data['account']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">密码：</td>
                <td>
                    <input type="password" size="25" name="password" />
                   	密码留空，代码不修改密码
                </td>
            </tr>
            <!--<tr>
                <td class="label">确认密码：</td>
                <td>
                    <input type="password" size="25" name="cpassword" />
                </td>
            </tr>-->
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>


<script>
</script>
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<!--分类选择高亮js引入-->
<script type="text/javascript" src="/Public/Admin//Public/Home/Js/tron.js"></script>
<script type="text/javascript" src="/Public/Admin//Public/Home/Js/jquery.js"></script>