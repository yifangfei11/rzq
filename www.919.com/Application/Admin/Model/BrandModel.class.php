<?php
    namespace  Admin\Model;
    use  Think\Model;
    class  BrandModel extends Model
    {
        protected $insertFields='brand_name,logo,site_url,sm_logo';
        protected $updateFields='id,brand_name,logo,site_url,sm_logo';
        //自动提示验证
        protected  $_validate=array(
            array('brand_name','require','品牌名称不能为空',1),
            array('brand_name','1,180','品牌名称不能超过180个字符',1,'length',3),
        );
        protected  function _before_insert(&$data,$option)
        {   //上传图片
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
                {
                    $logo=$info['logo']['savepath'] . $info['logo']['savename'];
                    $sm_logo=$info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
                    //实例化图片类
                    $image = new \Think\Image();
                    $image->open('./Public/Uploads/'.$logo);
                    // 按照原图的比例生成一个最大为700*7000的缩略图并保存
                    $image->thumb(130, 130)->save('./Public/Uploads/'.$sm_logo);
                    //保存图片
                    $data['logo'] = $info['logo']['savepath'] . $info['logo']['savename'];
                    $data['sm_logo'] = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
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
                {
                    $logo=$info['logo']['savepath'] . $info['logo']['savename'];
                    $sm_logo=$info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
                    //实例化图片类
                    $image = new \Think\Image();
                    $image->open('./Public/Uploads/'.$logo);
                    // 按照原图的比例生成一个最大为700*7000的缩略图并保存
                    $image->thumb(130, 130)->save('./Public/Uploads/'.$sm_logo);
                    //获取当前商品图片
                    //$id=I('post.id');
                    $id=$option['where']['id'];
                    //查出原来图片的路径
                    $oldlogo=$this->field('logo,sm_logo')->find($id);
                    $sm_oldlogo=$oldlogo['sm_logo'];
                    $logo_oldlogo=$oldlogo['logo'];
                    //从硬盘上删除
                    @unlink('./Public/Uploads/'.$sm_oldlogo);
                    @unlink('./Public/Uploads/'.$logo_oldlogo);
                    //保存图片放数据库
                    $data['logo'] = $info['logo']['savepath'] . $info['logo']['savename'];
                    $data['sm_logo'] = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
                }

            }
        }
        //删除商品时的删除图片
        protected function  _before_delete($data)
        {
            $id=I('post.id');
            //$id=$option['where']['id'];
            //查出原来图片的路径
            $oldlogo=$this->field('logo,sm_logo')->find($id);
            $sm_oldlogo=$oldlogo['sm_logo'];
            $logo_oldlogo=$oldlogo['logo'];
            //从硬盘上删除
            @unlink('./Public/Uploads/'.$sm_oldlogo);
            @unlink('./Public/Uploads/'.$logo_oldlogo);
        }
        public  function  search()
        {
            //搜索
            $gn=I('get.gn');
            $where=[];
            //根据品牌名称搜索
            if ($gn)
            {
                $where['brand_name']=array('like',"%$gn%");
            }
            $count = $this->where($where)->count();// 查询满足要求的总记录数
            $Page  = new \Think\Page($count,5);// 实例化分页类 传入总记录数和每页显示的记录数(5)
            $Page->setConfig('prev','上一页');
            $Page->setConfig('next','下一页');
            $PageString  = $Page->show();// 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $data = $this->limit($Page->firstRow.','.$Page->listRows)->where($where)->select();
            // return $this->select();
            return array(
                'data'=>$data,
                'PageString'=>$PageString,
            );
        }
    }
