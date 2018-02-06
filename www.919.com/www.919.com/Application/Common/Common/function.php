<?php
// 有选择性的过滤XSS --》 说明：性能非常低-》尽量少用
function removeXSS($data)
{
    require_once './HtmlPurifier/HTMLPurifier.auto.php';
    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    // 设置保留的标签
    $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    // 执行过滤
    return $_clean_xss_obj->purify($data);
}


//使用一个表中的数据制作下拉框
function buildSelect($tableName,$selectName,$valueFieldName,$textFieldName,$selectedValue='')
{
    $model=D($tableName);
    $data=$model->field("$valueFieldName,$textFieldName")->select();
    $select="<select name='$selectName' ><option value=''>请选择</option>";
    foreach ($data as $k=>$v)
    {
        $value=$v[$valueFieldName];
        $text=$v[$textFieldName];
        if ($selectedValue && $selectedValue==$value)
            $selected='selected="selected"';
        else
            $selected ='';
        $select.='<option'.$selected.' value="'.$value.'">'.$text.'</option>';
    }
    $select.='</select>';
    echo $select;
}