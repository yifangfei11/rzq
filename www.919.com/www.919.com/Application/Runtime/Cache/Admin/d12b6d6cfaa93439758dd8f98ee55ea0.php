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

<div class="form-div">
    <form action="/index.php/Admin/Attribute/lst" name="searchForm" method="GET">
        <!--搜索模块-->
        <!-- 商品名称查询 -->
        <p>
            属性名称：<input type="text" name="gn" size="20"  value="<?php echo I('get.gn') ?>"/>
        </p>
        <p>
            <input type="submit" value=" 搜索 " class="button" />
        </p>
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>属性名称</th>
                <th>属性类型</th>
                <th>属性可选值(多个值用,号隔开)</th>
                <th>类型id</th>
                <th>操作</th>
            </tr>
                <?php foreach($data as $k=>$v) :?>
            <tr>
                <td align="center"><?php echo $v['attr_name']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $v['attr_type']; ?></span></td>
                <td align="center"><?php echo $v['attr_option_values']; ?></td>
                <td align="center"><?php echo $v['type_id']; ?></td>
                <td align="center">
                    <a href="<?php echo U('Attribute/edit?id='.$v['id']); ?>">修改</a>
                    <a onclick=" return confirm('确定要删除吗？')" href="<?php echo U('Attribute/delete?id='.$v['id']); ?>">删除</a>
                </td>
            </tr>
            <?php endforeach ; ?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $PageString; ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>

<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<!--分类选择高亮js引入-->
<script type="text/javascript" src="/Public/Admin/__PUBLIC__/Home/Js/tron.js"></script>
<script type="text/javascript" src="/Public/Admin/__PUBLIC__/Home/Js/jquery.js"></script>