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
    <form action="/index.php/Admin/Goods/lst" name="searchForm" method="GET">
        <!--搜索模块-->
        <!-- 商品名称查询 -->
        <p><!--<img src="/Public/Admin/Images/icon_search.gif" width="26" height="22" border="0" alt="search" />-->
            商品名称： <input type="text" name="gn" size="20"  value="<?php echo I('get.gn') ?>"/></p>
        <p>价&nbsp;&nbsp;&nbsp;格从 <input type="text" name="fp" size="10"  value="<?php echo I('get.fp') ?>"/>&nbsp;到&nbsp;<input type="text" name="tp" size="10"  value="<?php echo I('get.tp') ?>"/></p>
        <!--分类搜索-->
        <p>
            分类：
            <?php $catId=I('get.cat_id') ?>
            <select name="cat_id">
                <option value="">选择分类</option>
                <?php foreach($catData as $k=>$v): if($v['id'] == $catId) { $select='selected ="selected"'; } else { $select=''; } ?>
                <option <?php echo $select;?> value="<?php echo $v['id']?>"><?php echo str_repeat('.',$v['level']*8).$v['cat_name'];?></option>
                <?php endforeach;?>
            </select>
        </p>
        <!-- 上架查询 -->
        <p>是否上架：<input type="radio" name="ios" value=""  <?php if(I('ios')=='') echo'checked="checked"' ?> />全部
        <input type="radio" name="ios" value="是"  <?php if(I('ios')=='是') echo'checked="checked"' ?> />是
        <input type="radio" name="ios" value="否"  <?php if(I('ios')=='否') echo'checked="checked"' ?> />否
        <!--添加时间查询 -->
        <p>上架时间：从 <input type="text" id="fa" name="fa" size="10"  value="<?php echo I('get.fa') ?>"/>&nbsp;到&nbsp;<input type="text" id="ta" name="ta" size="10"  value="<?php echo I('get.ta') ?>"/></p>
        <p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>主分类</th>
                <th>品牌</th>
                <th>图片</th>
                <th>商品名称</th>
                <th>本店价格</th>
                <th>市场价格</th>
                <th>是否上架</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>

                <?php foreach($data as $k=>$v) :?>
            <tr>
                <td align="center"><?php echo $v['id']; ?></td>
                <td align="center"><?php echo $v['cat_name']; ?></td>
                <td align="center"><?php echo $v['brand_name']; ?></td>
                <td><img src="/Public/Uploads/<?php echo $v['sm_logo']; ?>"></td>
                <td align="center" class="first-cell"><span><?php echo $v['goods_name']; ?></span></td>
                <td align="center"><?php echo $v['shop_price']; ?></td>
                <td align="center"><?php echo $v['market_price']; ?></td>
                <td align="center"><?php echo $v['is_on_sale']; ?></td>
                <td align="center"><?php echo $v['addtime']; ?></td>
                <td align="center">
                    <a href="<?php echo U('goods_number?id='.$v['id']); ?>">库存量</a>
                    <a href="<?php echo U('Goods/edit?id='.$v['id']); ?>">修改</a>
                    <a onclick=" return confirm('确定要删除吗？')" href="<?php echo U('Goods/delete?id='.$v['id']); ?>">删除</a>
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

<script type="text/javascript" src="/Public/Admin/Js/jquery.js"></script>