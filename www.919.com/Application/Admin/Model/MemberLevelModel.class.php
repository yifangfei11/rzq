<?php
namespace  Admin\Model;
use Think\Model;
class  MemberLevelModel  extends Model
{
    protected $insertFields='level_name,jifen_bottom,jifen_top';
    protected $updateFields='id,level_name,jifen_bottom,jifen_top';
    //自动提示验证
    protected  $_validate=array(
        array('level_name','require','会员名称不能为空',1),
        array('jifen_bottom','number','积分下限必须为数字',1),
        array('jifen_top','number','积分上限必须为数字',1),
    );
}