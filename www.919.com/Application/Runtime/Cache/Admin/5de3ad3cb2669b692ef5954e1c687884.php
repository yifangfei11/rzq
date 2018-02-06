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
        <form enctype="multipart/form-data" action="/index.php/Admin/Attribute/edit/id/11.html" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'];?>"/>
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">属性名称：</td>
                    <td><input type="text" name="attr_name" value="<?php echo $data['attr_name'];?>"size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <td class="label">属性类型：</td>
                <td>
                    <?php if($data['attr_type']=='可选') $checked='checked="checked";'?>
                    <?php if($data['attr_type']=='唯一') $checked1='checked1="checked";'?>
                    <input type="radio" name="attr_type" value="可选"size="20"  <?php echo checked;?>/>可选
                    <input type="radio" name="attr_type" value="唯一"size="20" <?php echo checked1;?>/>唯一
                </td>
                <tr>
                    <td class="label">属性可选值：</td>
                    <td><textarea name="attr_option_values"  cols="30" rows="10"><?php echo $data['attr_option_values'];?></textarea>
                </tr>
                <tr>
                    <td class="label">所属类型：</td>
                    <td>
                        <select name="type_id">
                            <option value="">请选择</option>
                            <?php foreach($typeData as $k=>$v): if($v['id']==$data['type_id']) { $select='selected="selected"'; } else { $select=''; } ?>
                            <option <?php echo $select;?> value="<?php echo $v['id']?>"><?php echo $v['type_name']?></option>
                            <?php endforeach;?>
                        </select>
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

<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<!--分类选择高亮js引入-->
<script type="text/javascript" src="/Public/Admin/__PUBLIC__/Home/Js/tron.js"></script>
<script type="text/javascript" src="/Public/Admin/__PUBLIC__/Home/Js/jquery.js"></script>