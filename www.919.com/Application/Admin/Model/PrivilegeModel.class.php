<?php
namespace Admin\Model;
use Think\Model;
class  PrivilegeModel extends  Model
{
    protected $insertFields='pri_name,parent_id,module_name,controller_name,action_name';
    protected $updateFields='id,pri_name,parent_id,module_name,controller_name,action_name';
    public  function  getChildren($catId)
    {
        $data=$this->select();
        return $this->_getChildren($data,$catId,true);
    }
    private  function _getChildren($data,$catId,$isClear=false)
    {
        static $_ret=array();
        if ($isClear)
        {
            $_ret=array();
        }
        foreach ($data as $k=>$v)
        {
            if ($v['parent_id']==$catId)
            {
                $_ret[]=$v['id'];
                $this->_getChildren($data,$v['id']);
            }
        }
         return $_ret;
    }

    public  function  getTree()
    {
        $data=$this->select();
        return $this->_getTree($data);
    }
    public  function  _getTree($data,$parent_id=0,$level=0)
    {
        static $_ret=array();
        foreach ($data as $k=>$v)
        {
            if ($v['parent_id']==$parent_id)
            {
                $v['level']=$level;
                $_ret[]=$v;
                $this->_getTree($data,$v['id'],$level+1);
            }
        }
        return $_ret;
    }

   /* protected  function  before_delete($option)
    {
        //$id=I('get.id');
        $id=$option['where']['id'];
        $children=$this->getChildren($id);
        $childrenCat=implode(',',$children);
        $Model=new  \Think\Model();
        $Model->table("__PRIVILEGE__")->delete($childrenCat);
    }*/
    public function _before_delete($option)
    {
        // 先找出所有的子分类
        $children = $this->getChildren($option['where']['id']);
        // 如果有子分类都删除掉
        if($children)
        {
            $this->error = '有下级数据无法删除';
            return FALSE;
        }
        // 从中间表中把这个权限相关的数据删除
        $rpModel = D('role_pri');
        $rpModel->where(array(
            'pri_id' => array('eq', $option['where']['id'])
        ))->delete();
    }

    //根据权限控制判断登录账号访问权限
    public function  checkPri()
    {
        $adminId=session('id');
        //判断如果是超级管理员直接返回true
        if ($adminId==1)
        {
            return true;
        }
        $arModel=D('AdminRole');
        $data=$arModel->alias('a')
                      ->join("LEFT JOIN __ROLE_PRI__ b ON a.role_id=b.role_id
                              LEFT JOIN __PRIVILEGE__ c ON  b.pri_id=c.id
                      ")
                      ->where(array(
                          'a.admin_id'=>array('eq',$adminId),
                          'c.module_name'=>array('eq',MODULE_NAME),
                          'c.controller_name'=>array('eq',CONTROLLER_NAME),
                          'c.action_name'=>array('eq',ACTION_NAME),
                      ))
                      ->count();
        return ($data > 0);
    }
}