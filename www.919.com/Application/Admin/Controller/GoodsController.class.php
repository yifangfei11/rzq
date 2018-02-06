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

       //先取出这件商品所有可选的属性值
      public  function  goods_number()
      {
          // 接收商品ID
          $id = I('get.id');
          //dump($id);die;
          $gnModel = D('goods_number');
          // 处理表单
          if(IS_POST)
          {
              // 先删除原库存
              $gnModel->where(array(
                  'goods_id' => array('eq', $id),
              ))->delete();
              //var_dump($_POST);die;
              $gaid = I('post.goods_attr_id');
              //dump($gaid);die;
              $gn = I('post.goods_number');
              // 先计算商品属性ID和库存量的比例
              $gaidCount = count($gaid);
              $gnCount = count($gn);
              $rate = $gaidCount/$gnCount;
              // 循环库存量
              $_i = 0;  // 取第几个商品属性ID
              foreach ($gn as $k => $v)
              {
                  $_goodsAttrId = array();  // 把下面取出来的ID放这里
                  // 后来从商品属性ID数组中取出 $rate 个，循环一次取一个
                  for($i=0; $i<$rate; $i++)
                  {
                      $_goodsAttrId[] = $gaid[$_i];
                      $_i++;
                  }
                  // 先升序排列
                  sort($_goodsAttrId, SORT_NUMERIC);  // 以数字的形式排序
                  // 把取出来的商品属性ID转化成字符串
                  $_goodsAttrId = (string)implode(',', $_goodsAttrId);
                  $gnModel->add(array(
                      'goods_id' => $id,
                      'goods_attr_id' => $_goodsAttrId,
                      'goods_number' => $v,
                  ));
              }
              $this->success('设置成功！', U('goods_number?id='.I('get.id')));
              exit;
          }
          header("Content-Type:text/html; charset=utf-8");
          //接收商品id
          $id=I('get.id');
          //根据商品id 取出这件商品所有可选属性的值
          //goods_attr商品属性表
          $gaModel=D('goods_attr');
          $gaData=$gaModel->alias('a')
                          ->join("LEFT JOIN __ATTRIBUTE__ b ON  a.attr_id=b.id")
                          ->where(array(
                              'a.goods_id'=>array('eq',$id),
                              'b.attr_type'=>array('eq','可选')
                          ))
                          ->select();
          //dump($gaData);die;
          // 处理这个二维数组：转化成三维：把属性相同的放到一起
          $_gaData = array();
          foreach ($gaData as $k => $v)
          {
              $_gaData[$v['attr_name']][] = $v;
          }

          // 先取出这件商品已经设置过的库存量
          $gnData = $gnModel->where(array(
              'goods_id' => $id,
          ))->select();
          //var_dump($gnData);

          $this->assign(array(
              'gaData' => $_gaData,
              'gnData' => $gnData,
          ));

          // 设置页面信息
          $this->assign(array(
              '_page_title'=>'库存量',
              '_btn_name'=>'返回列表',
              '_address_name'=>U('lst'),
          ));
          // 1.显示表单
          $this->display();
      }

    // 处理删除属性
    public function ajaxDelAttr()
    {
        $goodsId = addslashes(I('get.goods_id'));
        $gaid = addslashes(I('get.gaid'));
        $gaModel = D('goods_attr');
        $gaModel->delete($gaid);
        // 删除相关库存量数据
        $gnModel = D('goods_number');
        $gnModel->where(array(
            'goods_id' => array('EXP' ,"=$goodsId or AND FIND_IN_SET($gaid, attr_list)"),
        ))->delete();
    }

}