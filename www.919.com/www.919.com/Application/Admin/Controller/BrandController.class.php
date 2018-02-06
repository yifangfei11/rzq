<?php
    namespace  Admin\Controller;
    //use  Think\Controller;
    class  BrandController extends BaseController
    {//添加品牌
        public  function  add()
        {
            if (IS_POST)
            {
                //生成模型
                $BrandModel=D('Brand');
                //接收表单并且验证表单
                if ($BrandModel->create())
                {
                    //添加到数据库
                    if ($BrandModel->add())
                    {
                        $this->success('品牌添加成功！！',U('lst'));
                        exit;
                    }
                }
                //输出用户提示信息
                $error=$BrandModel->getError();
                $this->error($error);
            }
            else
            {
                //显示表单
                $this->assign(array(
                    '_page_title'=>'添加品牌',
                    '_btn_name'=>'品牌列表',
                    '_address_name'=>U('lst'),
                ));
                $this->display();
            }
        }
        //修改品牌
        public  function  edit()
        {
            //生成模型
            $BrandModel=D('Brand');
            if (IS_POST)
            {//接收表单并且验证表单
                if ($BrandModel->create())
                {
                    //添加到数据库
                    if ($BrandModel->save())
                    {
                        $this->success('品牌修改成功！！',U('lst'));
                        exit;
                    }
                }
                //输出用户提示信息
                $error=$BrandModel->getError();
                $this->error($error);
            }
            else
            {
                //取出商品的数据
                $id=I('get.id');
                $data=$BrandModel->find($id);
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
        //删除品牌
        public  function delete()
        {
            $id=I('get.id');
            $BrandModel=D('Brand');
            if ($BrandModel->delete($id)!==false)
            {
                $this->success('删除成功！！',U('lst'));
            }
            else
            {
                $this->error("删除失败，原因:".$BrandModel->getError());
            }

        }
        public  function  lst()
        {
            $BrandModel=D('Brand');
            $data=$BrandModel->search();
            $this->assign($data);
            $this->assign(array(
                '_page_title'=>'品牌列表',
                '_btn_name'=>'添加品牌',
                '_address_name'=>U('add'),
            ));
            $this->display();
        }
    }