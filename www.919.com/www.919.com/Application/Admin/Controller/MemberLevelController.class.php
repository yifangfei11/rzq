<?php
namespace  Admin\Controller;
//use   Think\Controller;
class  MemberLevelController extends BaseController
{
    //添加会员
    public  function  add()
    {
        if (IS_POST)
        {
            //生成模型
            $MemberLevelModel=D('MemberLevel');
            //接收表单并且验证表单
            if ($MemberLevelModel->create())
            {
                //添加到数据库
                if ($MemberLevelModel->add())
                {
                    $this->success('会员添加成功！！',U('lst'));
                    exit;
                }
            }
            //输出用户提示信息
            $error=$MemberLevelModel->getError();
            $this->error($error);
        }
        else
        {
            //显示表单
            $this->assign(array(
                '_page_title'=>'添加会员',
                '_btn_name'=>'会员列表',
                '_address_name'=>U('lst'),
            ));
            $this->display();
        }
    }
    //修改会员
    public  function  edit()
    {
        //生成模型
        $MemberLevelModel=D('MemberLevel');
        if (IS_POST)
        {//接收表单并且验证表单
            if ($MemberLevelModel->create())
            {
                //添加到数据库
                if (false !== $MemberLevelModel->save())
                {
                    $this->success('会员修改成功！！',U('lst'));
                    exit;
                }
            }
            //输出用户提示信息
            $error=$MemberLevelModel->getError();
            $this->error($error);
        }
        else
        {
            //取出商品的数据
            $id=I('get.id');
            $data=$MemberLevelModel->find($id);
            $this->assign('data',$data);
            $this->assign(array(
                '_page_title'=>'修改品牌',
                '_btn_name'=>'品牌列表',
                '_address_name'=>U('lst'),
            ));
            //显示表单
            $this->display();
        }
    }
    //删除会员
    public  function delete()
    {
        $id=I('get.id');
        $MemberLevelModel=D('MemberLevel');
        if ($MemberLevelModel->delete($id)!==false)
        {
            $this->success('删除成功！！',U('lst'));
        }
        else
        {
            $this->error("删除失败，原因:".$MemberLevelModel->getError());
        }

    }
    public  function  lst()
    {
        $MemberLevelModel=D('MemberLevel');
        $data=$MemberLevelModel->select();
        $this->assign('data',$data);
        $this->assign(array(
            '_page_title'=>'会员列表',
            '_btn_name'=>'添加会员',
            '_address_name'=>U('add'),
        ));
        $this->display();
    }
}