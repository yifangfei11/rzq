<?php
namespace Admin\Controller;
use Think\Controller;
use Exception;
class LoginController extends Controller
{
    public  function  captcha()
    {
        $config =	array(
            'seKey'     =>  'ThinkPHP.CN',   // 验证码加密密钥
            'codeSet'   =>  '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY', // 验证码字符集合
            'expire'    =>  1800,            // 验证码过期时间（s）
            'useZh'     =>  false,           // 使用中文验证码
            'useImgBg'  =>  false,           // 使用背景图片
            'fontSize'  =>  25,              // 验证码字体大小(px)
            'useCurve'  =>  false,            // 是否画混淆曲线
            'useNoise'  =>  false,            // 是否添加杂点
            'imageH'    =>  50,               // 验证码图片高度
            'imageW'    =>  145,               // 验证码图片宽度
            'length'    => 3,               // 验证码位数
            //'fontttf'   =>  'simhei.ttf',              // 验证码字体，不设置随机获取
            'bg'        =>  array(200, 251, 254),  // 背景颜色
            'reset'     =>  true,           // 验证成功后是否重置
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();

    }
    public  function  login()
    {
        if (IS_POST)
        {
            $LoginModel=D('Admin');
            if ($LoginModel->validate($LoginModel->_login_validate)->create())
            {
                try
                {
                    $LoginModel->login();
                    $this->success("登录成功！！",U('Index/index'));
                }
                catch (Exception $e)
                {
                    $this->error($e->getMessage());
                }
            }
            else
            {
                $this->error($LoginModel->getError());
            }
        }
        else
        {
            $this->display();
        }
    }
    public  function  loginOut()
    {
        session(null);
        redirect('login');
    }


}