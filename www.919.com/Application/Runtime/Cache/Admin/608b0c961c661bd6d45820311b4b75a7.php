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
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/edit/id/31.html" method="post">
            <input type="hidden" name="id" value="<?php echo $data['id'];?>"/>
            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="<?php echo $data['goods_name'];?>"size="30" />
                    <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">主分类：</td>
                    <td>
                        <select name="cat_id" >
                            <option value="">选择分类</option>
                            <?php foreach($catData as $k=>$v): if($v['id']==$data['cat_id']) { $select = 'selected="selected"'; } else { $select=''; } ?>
                            <option <?php echo $select;?> value="<?php echo $v['id']?>"><?php echo str_repeat('.',$v['levle']*8).$v['cat_name'];?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">品牌：</td>
                    <td>
                        <select name="brand_id" >
                            <option value="">请选择</option>
                            <?php foreach($brandData as $k=>$v):?>
                            <option value="<?php echo $v['id'];?>" <?php if($v['id']==$data['brand_id']) echo 'selected="selected"'?>><?php echo $v['brand_name']?></option>
                            <?php endforeach;?>

                        </select>
                    </td>
                <tr>
                    <td class="label"></td>
                    <td ><img src="/Public/Uploads/<?php echo $data['sm_logo'];?>" ></td>
                </tr>
                <tr>
                    <td class="label">logo：</td>
                    <td><input type="file" name="logo" value=""size="20" />
                </tr>

                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo $data['shop_price'];?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo $data['market_price'];?>" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <!-- <tr>
                     <td class="label">会员价格：</td>
                     <td>
                         <?php foreach($mblData as $k2=>$v2):?>
                         <?php echo $v2['level_name']?>
                         <input type="text" name="member_price[<?php echo $v2['id']; ?>]" value="<?php foreach($mpData as $k3=>$v3): if($v2['id']==$v3['level_id']&& $data['id']==$v3['goods_id']) echo $v3['price']; endforeach;?>" size="10" />
                         <?php endforeach;?>
                     </td>
                 </tr>-->
                <tr>
                    <td class="label">会员价格：</td>

                    <td>
                        <?php foreach($mpData as $k1=>$v1):?>
                        <?php echo $v1['level_name']?>
                        <input type="text" name="member_price[<?php echo $v1['level_id']; ?>]" value="<?php echo $v1['price']; ?>" size="10" />
                        <?php endforeach;?>
                    </td>

                </tr>

                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <?php if($data['is_on_sale']=='是') $checked='checked="checked";'?>
                        <?php if($data['is_on_sale']=='否') $checked1='checked="checked";'?>
                        <input type="radio" name="is_on_sale" value="是" <?php echo $checked;?>/> 是
                        <input type="radio" name="is_on_sale" value="否" <?php echo $checked1;?>/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <textarea id="editor" name="goods_desc" cols="40" rows="3"><?php echo $data['goods_desc'];?></textarea>
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
<script type="text/javascript" charset="utf-8" src="/Public/UEditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/UEditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Public/UEditor/lang/zh-cn/zh-cn.js"></script>
<script>
    var ue = UE.getEditor('editor',{

        initialFrameWidth:800 , //初始化编辑器宽度,默认1000
        initialFrameHeight:320  //初始化编辑器高度,默认320
    });
</script>
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<!--分类选择高亮js引入-->
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/jquery.js"></script>