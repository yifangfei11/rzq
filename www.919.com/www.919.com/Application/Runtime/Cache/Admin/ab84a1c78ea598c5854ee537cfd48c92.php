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

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" id="general-tab">通用信息</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Role/add.html" method="post">
            <table width="90%" id="general-table" align="center">

                <tr>
                    <td class="label">角色名称：</td>
                    <td><input type="text" name="role_name" value=""size="20" /></td>
                </tr>
                <tr>
                    <td class="label">权限列表：</td>
                    <td>
                        <?php foreach($priData as $k=>$v):?>
                        <?php echo str_repeat('.', $v['level']*8);?>
                        <input  level_id="<?php echo $v['level'];?>" type="checkbox" name="pri_id[]" value="<?php echo $v['id']?>"/>
                        <?php echo $v['pri_name']; ?></br>
                        <?php endforeach;?>
                    </td>
                </tr>

            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="/Public/Admin/__PUBLIC__/Home/Js/jquery.js"></script>
<script>
    // 为所有的复选框绑定一个点击事件
    $(":checkbox").click(function(){
        // 先获取点击的这个level_id
        var tmp_level_id = level_id = $(this).attr("level_id");
        // 判断是选中还是取消
        if($(this).prop("checked"))
        {
            // 所有的子权限也选中
            $(this).nextAll(":checkbox").each(function(k,v){
                if($(v).attr("level_id") > level_id)
                    $(v).prop("checked", "checked");
                else
                    return false;
            });
            // 所有的上级权限也选中
            $(this).prevAll(":checkbox").each(function(k,v){
                if($(v).attr("level_id") < tmp_level_id)
                {
                    $(v).prop("checked", "checked");
                    tmp_level_id--; // 再找更上一级的
                }
            });
        }
        else
        {
            // 所有的子权限也取消
            $(this).nextAll(":checkbox").each(function(k,v){
                if($(v).attr("level_id") > level_id)
                    $(v).removeAttr("checked");
                else
                    return false;
            });
        }
    });
</script>
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<!--分类选择高亮js引入-->
<script type="text/javascript" src="/Public/Admin/__PUBLIC__/Home/Js/tron.js"></script>
<script type="text/javascript" src="/Public/Admin/__PUBLIC__/Home/Js/jquery.js"></script>