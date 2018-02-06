<?php
namespace Admin\Controller;
//use Think\Controller;
class  PrivilegeController  extends BaseController
{
   public  function  add()
    {
        $PrivilegeModel=D('Privilege');
        if (IS_POST)
        {
            if ($PrivilegeModel->create(I('post.'), 1))
            {
                if ($PrivilegeModel->add())
                {
                    $this->success('权限添加成功！！！',U('lst?p='.I('get.p')));
                    exit;
                }
            }
            $this->error('权限添加失败！！失败原因：'.$PrivilegeModel->getError());
        }
        else
        {

        $priData = $PrivilegeModel->getTree();
        //dump($catData);die;
        $this->assign(array(
            'priData' =>$priData,
            '_page_title'=>'修改权限',
            '_btn_name'=>'权限列表',
            '_address_name'=>U('lst'),
        ));
        $this->display();
        }
    }
    public  function  edit()
    {
        $PrivilegeModel=D('Privilege');
        if (IS_POST)
        {
            if ($PrivilegeModel->create(I('post.'), 2))
            {
                if ($PrivilegeModel->save()!== FALSE)
                {
                    $this->success('权限修改成功！！！',U('lst',array('p' => I('get.p', 1))));
                    exit;
                }
            }
            $this->error('权限修改失败！！失败原因：'.$PrivilegeModel->getError());
        }
        else
        {
            $id=I('get.id');
            $data=$PrivilegeModel->find($id);
            //dump($data);die;
            $children=$PrivilegeModel->getChildren($id);
            $priData=$PrivilegeModel->getTree();
            //dump($priData);die;
            $this->assign(array(
             'data'=>$data,
             'priData'=>$priData,
             'children'=>$children,
        ));
            $this->display();
        }
    }
    public  function delete()
    {
        $id=I('get.id');
        $PrivilegeModel=D('Privilege');
        if (false!==$PrivilegeModel->delete($id))
        {
            $this->success('删除成功！！！',u('lst'));
        }
        else
        {
            $this->error('删除失败！！原因'.$PrivilegeModel->getError());
        }

    }
    public  function  lst()
    {
        $PrivilegeModel=D('Privilege');
       $priData=$PrivilegeModel->getTree();
       $this->assign(array(
           'priData'=>$priData,
           '_page_title'=>'权限列表',
           '_btn_name'=>'添加权限',
           '_address_name'=>U('add'),
       ));
       $this->display();
    }

}