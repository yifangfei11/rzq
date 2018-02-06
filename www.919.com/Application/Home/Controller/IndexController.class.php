<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index()
    {
        $Category=D('Admin/Category');
        $catData=$Category->getNavData();
        $this->assign(array(
            'catData'=>$catData,
        ));
        //dump($catData);die;
        $this->display();
    }
    // 商品详情页
    public function goods()
    {
        //接收商品的id
        $id=37;
        //根据id取出商品的详细信息
        $goodsModel=D('Admin/Goods');
        $info=$goodsModel->find($id);
        //dump($info);die;
        //dump($info);die;
        //再根据主分类ID找出这个分类所有上级分类制作导航
        $catModel=D('Admin/Category');
        $catPath=$catModel->parentPath($info['cat_id']);
        // 取出商品的相册
         $gpModel = D('Admin/Goods');
         $gpData = $gpModel->where(array(
         'goods_id' => array('eq', $id),
         ))->select();
        //取出这件商品的所有属性
        $gaModel=D('Admin/GoodsAttr');
        $gaData=$gaModel->alias('a')
                        ->field('a.*,b.attr_name,b.attr_type')
                        ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
                        ->where(array(
                            'a.goods_id'=>array('eq',$id),
                        ))
                        ->select();
        //整理所有的商品，把唯一的和可选的属性分开存放
        $uniArr=array(); //唯一属性
        $mulArr=array(); //可选属性
        foreach($gaData as $k=>$v)
        {
            if ($v['attr_type']=='唯一')
            {
                $uniArr[]=$v;
            }
            else
            {
                //把同一个属性放到一起 -》三维
                $mulArr[$v['attr_name']][]=$v;
            }
            //取出这件商品的所有会员价格
            $mpModel=D('Admin/MemberPrice');
            $mpData = $mpModel->alias('a')
                            ->field('a.price,b.level_name')
                            ->join('LEFT JOIN __MEMBER_LEVEL__ b ON a.level_id=b.id')
                            ->where(array(
                                'a.goods_id'=>array('eq',$id),
                            ))
                            ->select();
            $viewPath=C('IMAGE_CONFIG');
        }
        $this->assign(array(
            'gpData'=>$gpData,
            'info'=>$info,
            'catPath'=>$catPath,
            'uniArr'=>$uniArr,
            'mulArr'=>$mulArr,
            'mpData'=>$mpData,
            'viewPath'=>$viewPath['viewPath'],
        ));
        // 设置页面信息
        $this->assign(array(
            '_show_nav' => 0,
            '_page_title' => '商品详情页',
            '_page_keywords' => '商品详情页',
            '_page_description' => '商品详情页',
        ));
        $this->display();
    }
   /* public function goods()
    {
        // 接收商品的ID
        $id = 39;
        // 根据ID取出商品的详细信息
        $gModel = D('Goods');
        $info = $gModel->find($id);
        // 再根据主分类ID找出这个分类所有上级分类制作导航
        $catModel = D('Admin/Category');
        $catPath = $catModel->parentPath($info['cat_id']);
        // 取出商品的相册
       // $gpModel = D('goods_pic');
        //$gpData = $gpModel->where(array(
           // 'goods_id' => array('eq', $id),
        //))->select();
        //header('Content-Type:text/html;charset=utf-8;');
        // 取出这件商品所有的属性
        $gaModel = D('goods_attr');
        $gaData = $gaModel->alias('a')
            ->field('a.*,b.attr_name,b.attr_type')
            ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
            ->where(array(
                'a.goods_id' => array('eq', $id),
            ))
            ->select();
        // 整理所有的商品，把唯一的和可选的属性分开存放
        $uniArr = array();  // 唯一属性
        $mulArr = array();  // 可选属性
        foreach ($gaData as $k => $v)
        {
            if($v['attr_type'] == '唯一')
                $uniArr[] = $v;
            else
                // 把同一个属性放到一起 -》 三维
                $mulArr[$v['attr_name']][] = $v;
        }
        // 取出这件商品所有的会员价格
        $mpModel = D('member_price');
        $mpData = $mpModel->alias('a')
            ->field('a.price,b.level_name')
            ->join('LEFT JOIN __MEMBER_LEVEL__ b ON a.level_id=b.id')
            ->where(array(
                'a.goods_id' => array('eq', $id),
            ))
            ->select();

        $viewPath = C('IMAGE_CONFIG');

        $this->assign(array(
            'info' => $info,
            'catPath' => $catPath,
            //'gpData' => $gpData,
            'uniArr' => $uniArr,
            'mulArr' => $mulArr,
            'mpData' => $mpData,
            'viewPath' => $viewPath['viewPath'],
        ));

        // 设置页面信息
        $this->assign(array(
            '_show_nav' => 0,
            '_page_title' => '商品详情页',
            '_page_keywords' => '商品详情页',
            '_page_description' => '商品详情页',
        ));
        $this->display();
    }*/



}