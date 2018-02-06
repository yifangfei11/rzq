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
            <span class="tab-front">通用信息</span>
            <span class="tab-back">商品描述</span>
            <span class="tab-back">会员价格</span>
            <span class="tab-back">商品属性</span>
            <span class="tab-back">商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/add.html" method="post">
            <table  width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                        <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">主分类：</td>
                    <td>
                        <select name="cat_id" >
                            <option value="">选择分类</option>
                            <?php foreach($catData as $k=>$v):?>
                            <option value="<?php echo $v['id']?>"><?php echo str_repeat('.',$v['level']*8).$v['cat_name']?></option>
                            <?php endforeach;?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">品牌：</td>
                    <td>
                        <select name="brand_id" >
                            <option value="">请选择</option>
                            <?php foreach($brandData as $k=>$v):?>
                            <option value="<?php echo $v['id'];?>"><?php echo $v['brand_name']?></option>
                            <?php endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">logo：</td>
                    <td><input type="file" name="logo" value=""size="20" />
                </tr>

                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是"/> 是
                        <input type="radio" name="is_on_sale" value="否"/> 否
                    </td>
                </tr>
            </table>
            <table style="display:none;" width="100%" class="tab_table" align="center">
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <textarea id="editor" name="goods_desc" cols="40" rows="3"></textarea>
                    </td>
                </tr>
            </table>
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">会员价格：</td>

                    <td>
                        <?php foreach($mlData as $k1=>$v1):?>
                        <?php echo $v1['level_name']?>
                        ¥<input type="text" name="member_price[<?php echo $v1['id']; ?>]"size="10" />
                        <?php endforeach;?>
                    </td>
                </tr>
            </table>
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">商品类型：</td>
                    <td>
                        <?php buildSelect('Type','type_id','id','type_name',I('get.type_id')) ;?>
                    </td>
                </tr>
                <tr>
                    <td><ul id="attr_list"></ul></td>
                </tr>
            </table>
            <!-- 商品相册 -->
            <table style="display:none;" width="90%" class="tab_table" align="center">
                <tr>
                    <td>
                        <input id="btn_add_pic" type="button" value="添加一张" />
                        <hr />
                        <ul id="ul_pic_list"></ul>
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
<script type="text/javascript" charset="utf-8" src="/Public/Admin/Js/jquery.js"></script>

<script>
    var ue = UE.getEditor('editor',{

        initialFrameWidth:800 , //初始化编辑器宽度,默认1000
        initialFrameHeight:320  //初始化编辑器高度,默认320
    });
    /******** 切换的代码 *******/
    $("#tabbar-div p span").click(function(){
        // 点击的第几个按钮
        var i = $(this).index();
        // 先隐藏所有的table
        $(".tab_table").hide();
        // 显示第i个table
        $(".tab_table").eq(i).show();
        // 先取消原按钮的选中状态
        $(".tab-front").removeClass("tab-front").addClass("tab-back");
        // 设置当前按钮选中
        $(this).removeClass("tab-back").addClass("tab-front");
    });

    //选择类型获取属性的ajax
    $("select[name=type_id]").change(function(){
        var typeId=$(this).val();
        //如果选择一个类型就执行ajax取属性
        if(typeId>0)
        {
            $.ajax({
                type:"GET",
                url:"<?php echo U('ajaxGetAttr','',FALSE); ?>/type_id/"+typeId,
                dataType: "json",
                success : function (data) {
                    /**把服务器返回的属性循环拼成一个LI字符串，并显示在页面中**/
                    var li="";
                    //循环每个属性
                    $(data).each(function (k,v) {
                        li+='<li>';
                        //如果这个属性类型是可选的就有一个+
                        if(v.attr_type=='可选')
                            li+='<a onclick="addNewAttr(this);" href="#">[ + ]</a>';
                        //属性名称
                        li+=v.attr_name+':';
                        //如果属性有可选值就做下拉框，否则做文本框
                        if(v.attr_option_values == "")
                        {
                            li+='<input type="text" name="attr_value['+v.id+'][]" />';
                        }
                        else
                        {
                            li+='<select name="attr_value['+v.id+'][]"><option value="">请选择...</option>';
                            var _attr=v.attr_option_values.split(',');
                            //循环每个值制作option
                            for(var i=0; i<_attr.length; i++)
                            {
                                li+='<option value="'+_attr[i]+'">';
                                li+=_attr[i];
                                li+='</option>';
                            }
                            li+='</select>';
                        }
                        li+='</li>'
                    });
                    //把拼好的LI放到页面中
                    $("#attr_list").html(li);
                }
            });
        }
        else
            $("#attr_list").html(""); //如果选的是请 选择就直接清空
    });


    //点击属性的+号
    function addNewAttr(a)
    {
        //$(a)-->把a转换成jquery中的对象，然后才能调用jquery中的方法
        //先获取所在的li
        var li =$(a).parent();
        if($(a).text()=='[ + ]')
        {
            var newLi=li.clone();
            //+变-
            newLi.find("a").text('[ - ]');
            //新的放在li后面
            li.after(newLi);
        }
        else
        {
            li.remove();
        }
    }
</script>
<div id="footer">
    共执行 7 个查询，用时 0.028849 秒，Gzip 已禁用，内存占用 3.219 MB<br />
    版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>

<script type="text/javascript" src="/Public/Admin/Js/jquery.js"></script>