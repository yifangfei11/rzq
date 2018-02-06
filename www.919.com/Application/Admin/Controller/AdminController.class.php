<?php
namespace  Admin\Controller;
class AdminController  extends BaseController
{
    public function add()
    {
        $adminModel=D('Admin');
        if (IS_POST)
        {
            if ($adminModel->create())
            {
                if ($adminModel->add())
                {
                    $this->success('添加成功！！！',U('lst'));
                    exit;
                }
            }
            $this->error('添加失败！！！原因：'.$adminModel->getError());
        }
        else
            {
            $roleModel = D('Role');
            $roleData = $roleModel->select();
            $this->assign(array(
                'roleData' => $roleData,
            ));
            $this->display();
            }
    }
    public function  edit()
    {
        $adminModel=D('Admin');
        if (IS_POST)
        {
            if ($adminModel->create())
            {
                if ($adminModel->save()!==false)
                {
                    $this->success('修改成功！！！',U('lst'));
                    exit;
                }
            }
            $this->error('修改失败！！原因：'.$adminModel->getError());
        }
        else
        {

            $id=I('get.id');
            $data=$adminModel->find($id);
            //找到中间表的数据，修改
            $roleModel=D('Role');
            $roleData=$roleModel->select();
            $arModel=D('AdminRole');
            $roleId=$arModel->field('GROUP_CONCAT(role_id) role_id')
                            ->where(array('admin_id'=>array('eq',$id)))
                            ->find();
            $this->assign(array(
                'data'=>$data,
                'roleData'=>$roleData,
                'roleId'=>$roleId['role_id'],
            ));
            $this->display();
        }
    }
    public  function  delete()
    {
        $id=I('get.id');
        $adminModel=D('Admin');
        if ($adminModel->delete($id)!==false)
        {
            $this->success('删除成功！！',U('lst'));
            exit;
        }
        else
        {
            $this->error('删除失败！！原因：'.$adminModel->getError());
        }
    }

    public  function  lst()
    {
        $adminModel=D('Admin');
        $adminData=$adminModel->alias('a')
                              ->field('a.*,GROUP_CONCAT(c.role_name) role_name')
                              ->join("LEFT JOIN __ADMIN_ROLE__ b ON a.id=b.admin_id
                                      LEFT JOIN __ROLE__  c ON  b.role_id=c.id
                                    ")
                              ->group('a.id')
                              ->select();
        $this->assign(array(
            'adminData'=>$adminData,
            '_page_title'=>'管理员列表',
            '_btn_name'=>'添加管理员',
            '_address_name'=>U('add'),
        ));
        $this->display();
    }


}