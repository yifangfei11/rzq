<?php
namespace Admin\Controller;
//use Think\Controller;
class TypeController extends BaseController
{

    public  function  add()
    {
        if (IS_POST)
        {
            //生成模型
            $TypeModel=D('Type');
            //接收表单并且验证表单
            if ($TypeModel->create())
            {
                //添加到数据库
                if ($TypeModel->add())
                {
                    $this->success('类型添加成功！！',U('lst'));
                    exit;
                }
            }
            //输出用户提示信息
            $error=$TypeModel->getError();
            $this->error($error);
        }
        else
        {
            //显示表单
            $this->assign(array(
                '_page_title'=>'添加类型',
                '_btn_name'=>'类型列表',
                '_address_name'=>U('lst'),
            ));
            $this->display();
        }
    }
    //修改品牌
    public  function  edit()
    {
        //生成模型
        $TypeModel=D('Type');
        if (IS_POST)
        {//接收表单并且验证表单
            if ($TypeModel->create())
            {
                //添加到数据库
                if ($TypeModel->save())
                {
                    $this->success('类型修改成功！！',U('lst'));
                    exit;
                }
            }
            //输出用户提示信息
            $error=$TypeModel->getError();
            $this->error($error);
        }
        else
        {
            //取出商品的数据
            $id=I('get.id');
            $data=$TypeModel->find($id);
            $this->assign('data',$data);
            $this->assign(array(
                '_page_title'=>'修改类型',
                '_btn_name'=>'类型列表',
                '_address_name'=>U('lst'),
            ));
            //显示表单
            $this->display();
        }
    }
    //删除品牌
    public  function delete()
    {
        $id=I('get.id');
        $TypeModel=D('Type');
        if ($TypeModel->delete($id)!==false)
        {
            $this->success('删除成功！！',U('lst'));
        }
        else
        {
            $this->error("删除失败，原因:".$TypeModel->getError());
        }

    }
    public  function  lst()
    {
        $TypeModel=D('Type');
        $data=$TypeModel->select();
        $this->assign('data',$data);
        $this->assign(array(
            '_page_title'=>'类型列表',
            '_btn_name'=>'添加类型',
            '_address_name'=>U('add'),
        ));
        $this->display();
    }

}