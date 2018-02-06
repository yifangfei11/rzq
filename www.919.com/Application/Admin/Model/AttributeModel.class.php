<?php
namespace  Admin\Model;
use  Think\Model;
class  AttributeModel extends Model
{
    protected $insertFields='attr_name,attr_type,attr_option_values,type_id';
    protected $updateFields='id,attr_name,attr_type,attr_option_values,type_id';
    //自动提示验证
    protected  $_validate=array(
        array('attr_name','require','属性名称不能为空',1),
        //array('attr_name','','名称已存在',1,'unique'),
    );

    protected  function  _before_insert(&$data,$option)
    {
        //将添加到属性列表的中文符合修改问英文符号
        //把字符串 "Hello world!" 中的字符 "world" 替换为 "Shanghai"
        //echo str_replace("world","Shanghai","Hello world!");
        //$_POST['attr_option_values']=str_replace('，',',',$_POST['attr_option_values']);
        // 把中文 逗号换成英文的
        $data['attr_option_values'] = str_replace('，', ',', $data['attr_option_values']);
    }
}