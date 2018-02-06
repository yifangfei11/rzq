<?php
namespace  Admin\Controller;
//use Think\Controller;
class AttributeController extends BaseController
{
    public  function  add()
    {
        //生成模型
        $AttributeModel=D('Attribute');
        $id=I('type_id');
        if (IS_POST)
        {
            //接收表单并且验证表单
            if ($AttributeModel->create())
            {
                //添加到数据库
                if ($AttributeModel->add())
                {

                    $this->success('属性添加成功！！',U('lst?type_id='.$id));
                    exit;
                }
            }
            //输出用户提示信息
            $error=$AttributeModel->getError();
            $this->error($error);
        }
        else
        {
            $TypeModel=D('Type');
            $typeData=$TypeModel->select();
            $this->assign(array(
                'typeData'=>$typeData,
                '_page_title'=>'添加属性',
                '_btn_name'=>'属性列表',
                '_address_name'=>U('lst'),
            ));
            $this->display();
        }
    }
    //修改品牌
    public  function  edit()
    {
        //生成模型
        $AttributeModel=D('Attribute');
        if (IS_POST)
        {//接收表单并且验证表单
            if ($AttributeModel->create())
            {
                //添加到数据库
                if ($AttributeModel->save())
                {
                    $id=I('type_id');
                    $this->success('属性修改成功！！',U('lst?type_id='.$id));
                    exit;
                }
            }
            //输出用户提示信息
            $error=$AttributeModel->getError();
            $this->error($error);
        }
        else
        {
            $TypeModel=D('Type');
            $typeData=$TypeModel->select();
            //取出商品的数据
            $id=I('get.id');
            $data=$AttributeModel->find($id);
            $this->assign('data',$data);
            $this->assign(array(
                'typeData'=>$typeData,
                '_page_title'=>'修改属性',
                '_btn_name'=>'属性列表',
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
        $AttributeModel=D('Attribute');
        if ($AttributeModel->delete($id)!==false)
        {
            $this->success('删除成功！！',U('lst?type_id='.$id));
        }
        else
        {
            $this->error("删除失败，原因:".$AttributeModel->getError());
        }

    }
    public  function  lst()
    {
        $AttributeModel=D('Attribute');
        $id=I('type_id');
        $data=$AttributeModel->where('type_id='.$id)->select();
        $this->assign(array(
            'data'=>$data,
            '_page_title'=>'属性列表',
            '_btn_name'=>'添加属性',
            '_address_name'=>U('add'),
        ));
        $this->display();
    }

}