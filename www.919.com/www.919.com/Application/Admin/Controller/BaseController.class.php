<?php
namespace  Admin\Controller;
use Think\Controller;
class BaseController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!session('id'))
        {
            $this->error('请先登录！！',U('Login/login'));
        }
        //所有管理员都能进入后台首页
        if (CONTROLLER_NAME=='Index')
        {
            return true;
        }
        $priModel=D('Privilege');
        if (!$priModel->checkPri())
        {
          //$this->error('没有访问权限！！',1);
            $this->redirect('Index/index',array(),1,'没有权限！！');
        }
    }
}