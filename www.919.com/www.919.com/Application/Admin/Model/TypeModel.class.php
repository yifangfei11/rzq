<?php
namespace Admin\Model;
use Think\Model;
class TypeModel extends Model{
    protected $insertFields='type_name';
    protected $updateFields='id,type_name';
    //自动提示验证
    protected  $_validate=array(
        array('type_name','require','类型名称不能为空',1),
        array('type_name','','类型名称已存在',1,'unique'),
    );
}