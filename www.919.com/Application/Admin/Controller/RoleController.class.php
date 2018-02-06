<?php
namespace  Admin\Controller;
use Think\Controller;

class  RoleController extends Controller
{
    public function add()
    {
        $RoleModel=D('Role');
        if (IS_POST)
        {
            if ($RoleModel->create())
            {
                if ($RoleModel->add())
                {
                    $this->success('角色添加成功！！',U('lst'));
                    exit;
                }
            }
            $this->error("角色添加失败！！原因：".$RoleModel->getError());
        }
        else
        {
            $PrivilegeModel=D('Privilege');
            $priData=$PrivilegeModel->getTree();
            $this->assign(array(
                'priData'=>$priData,
                '_page_title'=>'角色列表',
                '_btn_name'=>'添加角色',
                '_address_name'=>U('lst'),
            ));
            $this->display();
        }
    }
    public  function  edit()
    {
        //$id=I('get.id');
        $RoleModel=D('Role');
        if (IS_POST)
        {
            if ($RoleModel->create())
            {
                if ($RoleModel->save()!==false)
                {
                    $this->success('修改成功！！！',U('lst'));
                    exit;
                }
            }
            $this->error('修改失败！！！原因：'.$RoleModel->getError());
        }
        else
        {
            $id=I('get.id');
            //dump($id);die;
            $data=$RoleModel->find($id);
            //dump($data);die;
            $PrivilegeModel=D('Privilege');
            $priData=$PrivilegeModel->getTree();
            //dump($priData);die;
            $rolepriModel=D('RolePri');
            $rpData=$rolepriModel->field('GROUP_CONCAT(pri_id) pri_id')
                                 ->where(array('role_id'=>array('eq', $id),))
                                 ->find();
            //dump($rpData);die;
            $this->assign(array(
                'rpData'=>$rpData,
                'data'=>$data,
                'priData'=>$priData,
            ));
            $this->display();
        }
    }
    public  function delete()
    {
        $id=I('get.id');
        $RoleModel=D('Role');
        if (false!==$RoleModel->delete($id))
        {
            $this->success('删除成功！！！',u('lst',array('p' => I('get.p', 1))));
        }
        else
        {
            $this->error('删除失败！！原因'.$RoleModel->getError());
        }
    }
    public  function  lst()
    {
        $RoleModel=D('Role');
        $RoleData=$RoleModel->field('a.*, GROUP_CONCAT(c.pri_name) pri_name')
                            ->alias('a')
                            ->join("LEFT JOIN __ROLE_PRI__ b ON a.id=b.role_id
                                    LEFT JOIN __PRIVILEGE__ c ON b.pri_id=c.id
                                  ")
                            ->group('a.id')
                            ->select();
        $this->assign(array(
           'RoleData'=> $RoleData,
            '_page_title'=>'角色列表',
            '_btn_name'=>'添加角色',
            '_address_name'=>U('add'),
        ));

       $this->display();

    }
}