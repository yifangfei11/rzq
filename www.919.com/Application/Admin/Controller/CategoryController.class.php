<?php
namespace Admin\Controller;
//use Think\Controller;
class  CategoryController  extends BaseController
{
   public  function  add()
    {
        $CategoryModel=D('Category');
        if (IS_POST)
        {
            if ($CategoryModel->create())
            {
                if ($CategoryModel->add())
                {
                    $this->success('分类添加成功！！！',U('lst'));
                    exit;
                }
            }
            $this->error('分类添加失败！！失败原因：'.$CategoryModel->getError());
        }
        else
        {

        $catData = $CategoryModel->getTree();
        //dump($catData);die;
        $this->assign(array(
            'catData' =>$catData,
            '_page_title'=>'修改品牌',
            '_btn_name'=>'分类列表',
            '_address_name'=>U('lst'),
        ));
        $this->display();
        }
    }
    public  function  edit()
    {
        if (IS_POST)
        {
            $CategoryModel=D('Category');
            if ($CategoryModel->create())
            {
                if ($CategoryModel->save())
                {
                    $this->success('分类修改成功！！！',U('lst'));
                    exit;
                }
            }
            $this->error('分类修改失败！！失败原因：'.$CategoryModel->getError());
        }
        else
        {
            $CategoryModel=D('Category');
            $children=$CategoryModel->getChildren(I('id'));
            $catData=$CategoryModel->getTree();
             $this->assign(array(
             'catData'=>$catData,
             'children'=>$children,
        ));
            $this->display();
        }
    }
    public  function delete()
    {
        $id=I('get.id');
        $categoryModel=D('Category');
        if (false!==$categoryModel->delete($id))
        {
            $this->success('删除成功！！！',u('lst'));
        }
        else
        {
            $this->error('删除失败！！原因'.$categoryModel->getError());
        }

    }
    public  function  lst()
    {
       $CategoryModel=D('Category');
       $catData=$CategoryModel->getTree();
       $this->assign(array(
           'catData'=>$catData,
           '_page_title'=>'分类列表',
           '_btn_name'=>'添加分类',
           '_address_name'=>U('add'),
       ));
       $this->display();
    }

}