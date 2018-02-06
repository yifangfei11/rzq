<?php
namespace  Admin\Model;
use  Think\Model;
use Think\Think;

class  GoodsModel extends Model{
    //添加控制字段
  protected $insertFields='goods_name,shop_price,market_price,is_on_sale,goods_desc,logo,sm_logo,mid_logo,big_logo,mbig_logo,brand_id,brand_name,cat_id';
  protected $updateFields='id,goods_name,shop_price,market_price,is_on_sale,goods_desc,logo,sm_logo,mid_logo,big_logo,mbig_logo,brand_id,brand_name,cat_id';
    //自动提示验证
  protected  $_validate=array(
      array('goods_name','require','商品名称不能为空',1),
      array('cat_id','require','必须选择主分类',1),
      array('shop_price','currency','商品价格必须为货币形式',1),
      array('market_price','currency','商品市场价格必须为货币形式',1),
      array('goods_desc','require','商品描述不能为空',1)
  );
  protected  function _before_insert(&$data,$option)
  {
      //$date=date('Y-m-d H:i:s');
      //系统自动显示添加时间
      $data['addtime'] = date('Y-m-d H:i:s');
      $data['goods_desc'] = $_POST['goods_desc'];
      //上传图片
      if ($_FILES['logo']['error'] == 0)
      {
          $upload = new \Think\Upload();// 实例化上传类
          $upload->maxSize = 3145728;// 设置附件上传大小
          $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
          $upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
          $upload->savePath = 'Goods/'; // 设置附件上传（子）目录
          // 上传文件
          $info = $upload->upload();
          //dump($info);die;
          if (!$info)
          {// 上传错误提示错误信息
              //$this->error($upload->getError());
              //$error=$upload->getError();
              //$this->error=$error;
              $this->error = $upload->getError();
              return false;
          }
          else
              {// 上传成功
              //$this->success('上传成功！');
              //$data['logo'] = $info['logo']['savepath'] . $info['logo']['savename'];
              $logo=$info['logo']['savepath'] . $info['logo']['savename'];
              $mbig_logo=$info['logo']['savepath'] .'mbig_'. $info['logo']['savename'];
              $big_logo=$info['logo']['savepath'] .'big_'. $info['logo']['savename'];
              $mid_logo=$info['logo']['savepath'] .'mid_'. $info['logo']['savename'];
              $sm_logo=$info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
              //实例化图片类
              $image = new \Think\Image();
              $image->open('./Public/Uploads/'.$logo);
              // 按照原图的比例生成一个最大为700*7000的缩略图并保存
              $image->thumb(700, 700)->save('./Public/Uploads/'.$mbig_logo);
              $image->thumb(350, 350)->save('./Public/Uploads/'.$big_logo);
              $image->thumb(130, 130)->save('./Public/Uploads/'.$mid_logo);
              $image->thumb(50, 50)->save('./Public/Uploads/'.$sm_logo);
              //保存图片
              $data['logo'] = $info['logo']['savepath'] . $info['logo']['savename'];
              $data['sm_logo'] = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
              $data['mid_logo'] = $info['logo']['savepath'] .'mid_'.$info['logo']['savename'];
              $data['big_logo'] = $info['logo']['savepath'] .'big_'. $info['logo']['savename'];
              $data['mbig_logo'] = $info['logo']['savepath'] .'mbig_'. $info['logo']['savename'];

          }

      }
  }
  //商品添加关联会员价格
  protected  function  _after_insert(&$data,$option)
  {
      //dump($data);die;
      $member_price=I('post.member_price');
      //dump($member_price);die;
      $MemberPriceModel=D('MemberPrice');
      foreach ($member_price as $k=>$v)
      {
          $v=(float)$v;
          if ($v>0)
          {
              $MemberPriceModel->add(array(
                  'level_id' => $k,
                  'goods_id' => $data['id'],
                  'price' => $v,
              ));
          }
      }
  }
  protected  function  _after_update(&$data,$option)
  {
      //dump($data);die;
      $member_price=I('post.member_price');
     //dump($member_price);die;
      $MemberPriceModel=D('MemberPrice');
      $MemberPriceModel->where("goods_id=".$data['id'])->delete();
      foreach ($member_price as $k=>$v)
      {
          $v=(float)$v;
          if ($v>=0)
          {
            $MemberPriceModel->add(array(
                   'level_id' => $k,
                   'goods_id' => $data['id'],
                   'price' => $v,
              ));

          }
      }
  }
  protected function  _before_update(&$data,$option)
  {
      if ($_FILES['logo']['error'] == 0)
      {
          $upload = new \Think\Upload();// 实例化上传类
          $upload->maxSize = 3145728;// 设置附件上传大小
          $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
          $upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
          $upload->savePath = 'Goods/'; // 设置附件上传（子）目录
          // 上传文件
          $info = $upload->upload();
          //dump($info);die;
          if (!$info)
          {// 上传错误提示错误信息
              //$this->error($upload->getError());
              //$error=$upload->getError();
              //$this->error=$error;
              $this->error = $upload->getError();
              return false;
          }
          else
          {// 上传成功
              //$this->success('上传成功！');
              //$data['logo'] = $info['logo']['savepath'] . $info['logo']['savename'];
              $logo=$info['logo']['savepath'] . $info['logo']['savename'];
              $mbig_logo=$info['logo']['savepath'] .'mbig_'. $info['logo']['savename'];
              $big_logo=$info['logo']['savepath'] .'big_'. $info['logo']['savename'];
              $mid_logo=$info['logo']['savepath'] .'mid_'. $info['logo']['savename'];
              $sm_logo=$info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
              //实例化图片类
              $image = new \Think\Image();
              $image->open('./Public/Uploads/'.$logo);
              // 按照原图的比例生成一个最大为700*7000的缩略图并保存
              $image->thumb(700, 700)->save('./Public/Uploads/'.$mbig_logo);
              $image->thumb(350, 350)->save('./Public/Uploads/'.$big_logo);
              $image->thumb(130, 130)->save('./Public/Uploads/'.$mid_logo);
              $image->thumb(50, 50)->save('./Public/Uploads/'.$sm_logo);
              //获取当前商品图片
              //$id=I('post.id');
              $id=$option['where']['id'];
              //查出原来图片的路径
              $oldlogo=$this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
              $sm_oldlogo=$oldlogo['sm_logo'];
              $mid_oldlogo=$oldlogo['mid_logo'];
              $big_oldlogo=$oldlogo['big_logo'];
              $mbig_oldlogo=$oldlogo['mbig_logo'];
              $logo_oldlogo=$oldlogo['logo'];
              //从硬盘上删除
              @unlink('./Public/Uploads/'.$sm_oldlogo);
              @unlink('./Public/Uploads/'.$mid_oldlogo);
              @unlink('./Public/Uploads/'.$big_oldlogo);
              @unlink('./Public/Uploads/'.$mbig_oldlogo);
              @unlink('./Public/Uploads/'.$logo_oldlogo);
              //保存图片放数据库
              $data['logo'] = $info['logo']['savepath'] . $info['logo']['savename'];
              $data['sm_logo'] = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
              $data['mid_logo'] = $info['logo']['savepath'] .'mid_'.$info['logo']['savename'];
              $data['big_logo'] = $info['logo']['savepath'] .'big_'. $info['logo']['savename'];
              $data['mbig_logo'] = $info['logo']['savepath'] .'mbig_'. $info['logo']['savename'];

          }

      }
  }
  //删除商品时的删除图片
    protected function  _before_delete($data)
    {
        $id=I('post.id');
        //$id=$option['where']['id'];
        //查出原来图片的路径
        $oldlogo=$this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
        $sm_oldlogo=$oldlogo['sm_logo'];
        $mid_oldlogo=$oldlogo['mid_logo'];
        $big_oldlogo=$oldlogo['big_logo'];
        $mbig_oldlogo=$oldlogo['mbig_logo'];
        $logo_oldlogo=$oldlogo['logo'];
        //从硬盘上删除
        @unlink('./Public/Uploads/'.$sm_oldlogo);
        @unlink('./Public/Uploads/'.$mid_oldlogo);
        @unlink('./Public/Uploads/'.$big_oldlogo);
        @unlink('./Public/Uploads/'.$mbig_oldlogo);
        @unlink('./Public/Uploads/'.$logo_oldlogo);
    }
    protected  function  _after_delete($option)
    {
        $MemberPrice= new \Think\Model();
        $MemberPrice->table('__MEMBER_PRICE__')
                    ->where('goods_id='.$option['id'])
                    ->delete();
    }

  public  function  search($prepage=25)
  {
      //搜索
      $gn=I('get.gn');
      $where=[];
      //根据商品名搜索
      if ($gn)
      {
          $where['goods_name']=array('like',"%$gn%");
      }
      //主分类的搜索
      $catId=I('get.cat_id');
      if ($catId)
      {
          //先取出所有子分类的id
          $CategoryModel=D('Category');
          $children=$CategoryModel->getChildren($catId);
          //和子分类放一起
          $children[]=$catId;
          //搜索出所有这些分类下的商品
          $where['a.cat_id']=array('IN',$children);
      }
      //根据价格区间搜索
      $fp=I('get.fp');
      $tp=I('get.tp');
      if ($fp && $tp)
      {
          $where['shop_price']=array('between',array($fp,$tp));
      }
      elseif ($fp)
      {
          $where['shop_price']=array('EGT',$fp);
      }
      elseif ($tp)
      {
          $where['shop_price']=array('ELT',$tp);
      }
       //根据是否下架搜索
      $ios=I('get.ios');
      if ($ios=='是')
      {
          $where['is_on_sale']=array('eq','是');
      }
      elseif ($ios=='否')
      {
          $where['is_on_sale']=array('eq','否');
      }
      //根据添加时间查询
      $fa=I('get.fa');
      $ta=I('get.ta');
      if ($fa && $ta)
      {
          $where['addtime']=array('between',array($fa,$ta));
      }
      elseif ($fa)
      {
          $where['addtime']=array('EGT',$fa);
      }
      elseif ($ta)
      {
          $where['addtime']=array('ELT',$ta);
      }
      $count = $this->where($where)->count();// 查询满足要求的总记录数
      $Page  = new \Think\Page($count,$prepage);// 实例化分页类 传入总记录数和每页显示的记录数(5)
      $Page->setConfig('prev','上一页');
      $Page->setConfig('next','下一页');
      $PageString  = $Page->show();// 分页显示输出
      // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      $data = $this->limit($Page->firstRow.','.$Page->listRows)
                   ->alias('a')
                   ->field('a.*,b.brand_name,c.cat_name')
                   ->where($where)
                   ->join('LEFT JOIN __BRAND__ b on a.brand_id=b.id
                           LEFT JOIN  __CATEGORY__ c ON a.cat_id=c.id')
                   ->select();
      // return $this->select();
      return array(
          'data'=>$data,
          'PageString'=>$PageString,
      );
  }

}