<?php
namespace  Admin\Model;
use Think\Model;

class  RoleModel  extends Model
{
    //protected $insertFields='role_id,pri_id';
   // protected $updateFields='id,role_id,pri_id';
    public  function  _after_insert(&$data,$option)
    {
        $priId=I('post.pri_id');
        $rolepriModel=D('RolePri');
        foreach ($priId as $k=>$v)
        {
            $rolepriModel-> add(array(
                'role_id'=>$data['id'],
                'pri_id'=>$v,
            ));
        }
    }
    protected function _before_update(&$data, $option)
    {
        //dump($data);die;

        /******** 处理拥有 的权限ID **********/
        $priId = I('post.pri_id');
        $rolepriModel = D('RolePri');
        //dump($option);die;
        $rolepriModel->where(array(
            'role_id' => array('eq', $option['where']['id']),
        ))->delete();
        foreach ($priId as $v)
        {
            $rolepriModel->add(array(
                'pri_id' => $v,
                'role_id' => $option['where']['id'],
            ));
        }
    }
    protected function _before_delete($option)
    {
        // 从中间表中把这个权限相关的数据删除
        $rolepriModel = D('RolePri');
        $rolepriModel->where(array(
            'role_id' => array('eq', $option['where']['id'])
        ))->delete();
        $arModel = D('AdminRole');
        $arModel->where(array(
            'role_id' => array('eq', $option['where']['id'])
        ))->delete();
    }

}