<?php
namespace  Admin\Controller;
//use  Think\Controller;

class  GoodsController  extends BaseController
{
      //添加商品
      public  function  add()
      {
          if (IS_POST)
          {
              //dump($_POST);die;
              //生成模型
              $GoodsModel=D('Goods');
              //接收表单并且验证表单
              if ($GoodsModel->create())
              {
                  //添加到数据库
                  if ($GoodsModel->add())
                  {
                      $this->success('商品添加成功！！',U('lst'));
                      exit;
                  }
              }
              //输出用户提示信息
              $error=$GoodsModel->getError();
              $this->error($error);
          }
          else
          {
              //取出品牌数据
              $BrandModel=D('Brand');
              $brandData=$BrandModel->select();
              //dump($brandData);
              //取出会员价格表数据
              $MemberLevelModel=D('MemberLevel');
              $mlData=$MemberLevelModel->select();
             //dump($mlData);die;
             //取出所有分类做下拉框
              $CategoryModel=D('Category');
              $catData=$CategoryModel->getTree();
             //显示表单
              $this->assign(array(
                  'catData'=>$catData,
                  'mlData'=>$mlData,
                  'brandData'=>$brandData,
                  '_page_title'=>'添加商品',
                  '_btn_name'=>'商品列表',
                  '_address_name'=>U('lst'),
              ));
              $this->display();
          }
      }
      //修改商品
      public  function  edit()
      {
          //生成模型
          $GoodsModel=D('Goods');
          if (IS_POST)
          {//接收表单并且验证表单

              if ($GoodsModel->create())
              {
                  //添加到数据库

                  if (FALSE !== $GoodsModel->save())
                  {
//                      dump($_POST);die;
                      $this->success('商品修改成功！！',U('lst'));
                      exit;
                  }
              }
              //输出用户提示信息
              $error=$GoodsModel->getError();
              $this->error($error);
          }
          else
          {
              //取出品牌数据
              $BrandModel=D('Brand');
              $brandData=$BrandModel->select();
              //取出商品的数据
              $id=I('get.id');
              $data=$GoodsModel->find($id);
              //取出所有分类做下拉框
              $CatgoryModel=D('Category');
              $catData=$CatgoryModel->getTree();
              //取出会员价格表数据
             /* $MemberLevelModel=D('MemberLevel');
              $mblData=$MemberLevelModel->select();
              //dump($mblData);die;*/
              $id=I('get.id');
              $MemberPriceModel=D('MemberPrice');
              $mpData=$MemberPriceModel->where('goods_id='.$id)
                                       ->alias('a')
                                       ->field('a.*,b.level_name')
                                       ->join('LEFT JOIN __MEMBER_LEVEL__ b ON a.level_id=b.id')
                                       ->select();
              //dump($mpData);die;
              //dump($mpData['price']);die;
              $this->assign('data',$data);
              $this->assign(array(
                  'catData'=>$catData,
                  'mpData'=>$mpData,
                  /*'mblData'=>$mblData,*/
                  'brandData'=>$brandData,
                  '_page_title'=>'修改商品',
                  '_btn_name'=>'商品列表',
                  '_address_name'=>U('lst'),
              ));
              //显示表单
              $this->display();
          }
      }
      //删除商品
       public  function delete()
       {
           $id=I('get.id');
           $GoodsModel=D('Goods');
           if ($GoodsModel->delete($id)!==false)
           {
               $this->success('删除成功！！',U('lst'));
           }
           else
           {
               $this->error("删除失败，原因:".$GoodsModel->getError());
           }

       }
      //商品显示页面
      public  function  lst()
      {
         $GoodsModel=D('Goods');
         $data=$GoodsModel->search();
         //取出所有分类做下拉框
          $CategoryModel=D('Category');
          $catData=$CategoryModel->getTree();
         $this->assign($data);
          $this->assign(array(
              'catData'=>$catData,
              '_page_title'=>'商品列表',
              '_btn_name'=>'添加商品',
              '_address_name'=>U('add'),
          ));
         $this->display();
      }

      //处理获取属性的AJAX请求
      public  function ajaxGetAttr()
      {
          $typeId=I('get.type_id');
          $attrModel=D('Attribute');
          $attrData=$attrModel->where(array('type_id'=>array('eq',$typeId),))->select();
          echo json_encode($attrData);
      }
}