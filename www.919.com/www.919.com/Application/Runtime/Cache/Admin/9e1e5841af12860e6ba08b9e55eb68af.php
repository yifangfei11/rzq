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
    <form action="/index.php/Admin/Type/lst" name="searchForm" method="GET">
        <!--搜索模块-->
        <!-- 商品名称查询 -->
        <p>
            类型名称：<input type="text" name="gn" size="20"  value="<?php echo I('get.gn') ?>"/>
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
                <th>编号</th>
                <th>类型名称</th>
                <th>操作</th>
            </tr>
                <?php foreach($data as $k=>$v) :?>
            <tr>
                <td align="center" width="10%"><?php echo $v['id']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $v['type_name']; ?></span></td>
                <td align="center" width="15%">
                    <a href="<?php echo U('Attribute/lst?type_id='.$v['id']); ?>">属性列表</a>
                    <a href="<?php echo U('Type/edit?id='.$v['id']); ?>">修改</a>
                    <a onclick=" return confirm('确定要删除吗？')" href="<?php echo U('Type/delete?id='.$v['id']); ?>">删除</a>
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



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>管理中心 - 商品列表 </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
    <link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
</head>
<body>
<h1>
    <?php if($_page_btn_name): ?>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <?php endif; ?>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear:both"></div>
</h1>

<!--  内容  -->

<div class="form-div">
    <form action="/index.php/Admin/Type/lst" name="searchForm" method="GET">
        <!--搜索模块-->
        <!-- 商品名称查询 -->
        <p>
            类型名称：<input type="text" name="gn" size="20"  value="<?php echo I('get.gn') ?>"/>
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
                <th>编号</th>
                <th>类型名称</th>
                <th>操作</th>
            </tr>
                <?php foreach($data as $k=>$v) :?>
            <tr>
                <td align="center" width="10%"><?php echo $v['id']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $v['type_name']; ?></span></td>
                <td align="center" width="15%">
                    <a href="<?php echo U('Attribute/lst?type_id='.$v['id']); ?>">属性列表</a>
                    <a href="<?php echo U('Type/edit?id='.$v['id']); ?>">修改</a>
                    <a onclick=" return confirm('确定要删除吗？')" href="<?php echo U('Type/delete?id='.$v['id']); ?>">删除</a>
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


<div id="footer"> 39期 </div>
</body>
</html>