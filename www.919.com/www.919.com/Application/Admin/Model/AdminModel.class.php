<?php
namespace  Admin\Model;
use Think\Crypt\Driver\Think;
use Think\Model;
use Exception;
class  AdminModel extends Model
{

    protected  $_validate=array(
        array('account', 'require', '用户名不能为空！', 1, 'regex', 3),
        array('account', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
        // 第六个参数：规则什么时候生效： 1：添加时生效 2：修改时生效 3：所有情况都生效
        array('password', 'require', '密码不能为空！', 1, 'regex', 1),
        //array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
        //array('account', '', '用户名已经存在！', 1, 'unique', 3),

    );
    public  $_login_validate=array(
        array('account','require','账号不能为空',1),
        array('password','require','密码不能为空',1),
        array('captcha','require','验证码不能为空',1),
        array('captcha','check_verify','验证码不正确！',1,'callback'),
    );
    function check_verify($code,$id='')
    {
        $verify=new \Think\Verify();
        return $verify->check($code,$id);
    }
    public  function  login()
    {
        $account=I('account');
        $password=I('password');
        $user=$this->where(array('account'=>$account))->find();
        if ($user)
        {
            if ($user['password']==md5($password.C('MD5_SALT')))
            {
                //dump(md5($password.C('MD5_SALT')));die;
                $_SESSION['id']=$user['id'];
                $_SESSION['account']=$user['account'];
            }
            else
                throw  new  Exception('密码不正确！');
        }
        else
            throw  new  Exception('账号不存在！');
    }
     //添加前
      protected  function _before_insert(&$data,$option)
       {
           $data['password']=md5($data['password'].C('MD5_SALT'));
       }

       //添加后
     protected function _after_insert($data, $option)
      {
        $roleId = I('post.role_id');
        $arModel = D('admin_role');
        foreach ($roleId as $v)
         {
            $arModel->add(array(
                'admin_id' => $data['id'],
                'role_id' => $v,
            ));
         }
      }
     /* protected function _before_update(&$data,$option)
      {
          $roleId=I('post.role_id');
          $arModel=D('AdminRole');

      }*/
    // 修改前
    protected function _before_update(&$data, $option)
    {
        $roleId = I('post.role_id');
        $arModel = D('admin_role');
        $arModel->where(array(
            'admin_id' => $option['where']['id'],
        ))->delete();
        foreach ($roleId as $v)
        {
            $arModel->add(array(
                'admin_id' => $option['where']['id'],
                'role_id' => $v,
            ));
        }

        if($data['password'])
            $data['password'] = md5($data['password']);
        else
            unset($data['password']);   // 从表单中删除这个字段就不会修改这个字段了！！
    }

      protected function _before_delete($option)
      {
          dump($option);die;
          if ($option['where']['id']==1)
          {
              $this->error='超级管理员无法删除！';
              return false;
          }
          $arModel=D('AdminRole');
          $arModel->where(array('admin_id'=>array('eq',$option['where']['id'])))->delete();
      }
}