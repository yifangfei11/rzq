<?php
namespace Admin\Model;
use Think\Model;
class  CategoryModel extends  Model
{
    protected $insertFields='cat_name,parent_id';
    protected $updateFields='id,cat_name,parent_id';
    public  function  getChildren($catId)
    {
        $data=$this->select();
        return $this->_getChildren($data,$catId,true);
    }
    private  function _getChildren($data,$catId,$isClear=false)
    {
        static $_ret=array();
        if ($isClear)
        {
            $_ret=array();
        }
        foreach ($data as $k=>$v)
        {
            if ($v['parent_id']==$catId)
            {
                $_ret[]=$v['id'];
                $this->_getChildren($data,$v['id']);
            }
        }
         return $_ret;
    }

    public  function  getTree()
    {
        $data=$this->select();
        return $this->_getTree($data);
    }
    public  function  _getTree($data,$parent_id=0,$level=0)
    {
        static $_ret=array();
        foreach ($data as $k=>$v)
        {
            if ($v['parent_id']==$parent_id)
            {
                $v['level']=$level;
                $_ret[]=$v;
                $this->_getTree($data,$v['id'],$level+1);
            }
        }
        return $_ret;
    }

    protected  function  _before_delete($option)
    {
        //$id=I('get.id');
        $id=$option['where']['id'];
        $children=$this->getChildren($id);
        $childrenCat=implode(',',$children);
        $Model=new  \Think\Model();
        $Model->table("__CATEGORY__")->delete($childrenCat);
    }

    //前台首页分类栏显示
    public function  getNavData()
    {
        $catData=S("catData");
        if (!$catData)
        {
          $all=$this->select();
          $ret=array();
          foreach($all as $k=>$v)
          {
              if ($v['parent_id']==0)
              {
                  foreach ($all as $k1=>$v1)
                  {
                      if ($v1['parent_id']==$v['id'])
                      {
                          foreach ($all as $k2=>$v2)
                          {
                              if ($v2['parent_id']==$v1['id'])
                              {
                                  $v1['children'][]=$v2;
                              }
                          }
                          $v['children'][]=$v1;
                      }
                  }
                  $ret[]=$v;
              }
          }
           /* S(array(
                    'type'=>'memcache',
                    'host'=>'192.168.1.10',
                    'port'=>'11211',
                    'prefix'=>'think',
                    'expire'=>60)
            );*/
          S("catData",$ret,300);
           return $ret;
        }
        else
        {
            return $catData;
        }
    }
}