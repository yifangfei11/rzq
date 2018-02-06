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
//商品详情页
    public function goods()
    {
        //取出商品id
        $id=I('get.id');
        //根据id获取商品详情
        $GoodsModel=D('Goods');
        $goodsData=$GoodsModel->find($id);
        $this->display();
    }
}