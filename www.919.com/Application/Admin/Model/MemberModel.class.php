<?php
namespace  Admin\Model;
use Think\Model;
class  MemberModel extends Model
{
    protected $insertFields="username,password,face,jifen，cpassword";
    protected $updateFields="id,username,password,face,jifen，cpassword";
    protected $_validate=array(
        array('username','require','用户名不能为空!',1,'regex',3),
        array('username','1,30','用户名长度不能超过30个字符！',1,'length',3),
        array('password','require','密码不能为空!',1,'regex',3),
        array('username','6,20','密码长度不能超过6-20个字符！',1,'length',3),
        array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
        array('username', '', '用户名已经存在！', 1, 'unique', 3),
        array('chkcode', 'require', '验证码不能为空！', 1),
        array('chkcode', 'check_verify', '验证码不正确！', 1, 'callback'),
    );
    // 为登录的表单定义一个验证规则
    public $_login_validate = array(
        array('username', 'require', '用户名不能为空！', 1),
        array('password', 'require', '密码不能为空！', 1),
        array('checkCode', 'require', '验证码不能为空！', 1),
        array('checkCode', 'check_verify', '验证码不正确！', 1, 'callback'),
    );
    // 验证验证码是否正确
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
    public  function  login($needPassword = TRUE)
    {
        //从模型中获取用户名和密码
        $username=$this->username;
        if ($needPassword)
        {
            $password=$this->password;
        }
        //先查询这个用户名是否存在
        $user=$this->field('id,username,password,face,jifen')
                   ->where(array(
                       'username'=>array('eq',$username),
                   ))
                   ->find();
        if ($user)
        {
            if ($needPassword)
            {
                if ($user['password']==md5($password.C('MD5_SALT')))
                {
                    // 登录成功存session
                    session('m_id', $user['id']);
                    session('m_username', $user['username']);
                    session('face', '/Public/Home/images/user1.gif');
                    // 计算当前会员级别ID并存SESSION
                    $mlModel = D('member_level');
                    $levelId = $mlModel->field('id')->where(array(
                        'jifen_bottom' => array('elt', $user['jifen']),
                        'jifen_top' => array('egt', $user['jifen']),
                    ))->find();
                    session('level_id', $levelId['id']);
                    // move CartData in cart to db
                    $cartModel = D('Home/Cart');
                    $cartModel->moveDataToDb();
                    return TRUE;
                }
                else
                {
                    $this->error = '密码不正确！';
                    return FALSE;
                }
            }
            else
            {
                // 登录成功存session
                session('m_id', $user['id']);
                session('m_username', $user['username']);
                session('face', '/Public/Home/images/user1.gif');
                // 计算当前会员级别ID并存SESSION
                $mlModel = D('member_level');
                $levelId = $mlModel->field('id')->where(array(
                    'jifen_bottom' => array('elt', $user['jifen']),
                    'jifen_top' => array('egt', $user['jifen']),
                ))->find();
                session('level_id', $levelId['id']);
                // move CartData in cart to db
                $cartModel = D('Home/Cart');
                $cartModel->moveDataToDb();
                return TRUE;
            }
        }
        else
        {
            $this->error = '用户名不存在！';
            return FALSE;
        }

    }

}