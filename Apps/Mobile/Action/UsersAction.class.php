<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 用户控制器
 */
use Think\Controller;
class UsersAction extends BaseAction {
  /**
  *用户登录
  **/
  public function login()
  {
    $this->url = I('url');
    $this->view->display('/tpl/login');
  }
  /**
  *用户登录
  **/
  public function psw()
  {
    $this->view->display('/tpl/password');
  }
  /**
  *用户注册
  **/
  public function register(){
    $this->url = I('url');
    $this->view->display('/tpl/register');
  }
  /**
  *用户中心
  **/
  public function index()
  {
    $this->isLogin();
    $this->user = session('Users');
    $this->view->display('/tpl/user');
  }
  /**
  *用户收货地址
  **/
  public function userAddAddress()
  {
    $this->isLogin();
    $this->view->display('/tpl/addLinkman');
  }
  /**
  *用户收货地址
  **/
  public function addressList()
  {
    $this->isLogin();
    $this->view->display('/tpl/linkman');
  }
  /**
  *用户改名字
  **/
  public function reName()
  {
    $this->isLogin();
    $this->username = empty(session('Users')['userName'])?'':session('Users')['userName'];
    $this->view->display('/tpl/rename');
  }
  /**
  *用户注册ajxa手机号码验证操作
  **/
  public function regPhone(){
    $m = D('Mobile/Users');
    $rs = $m->regPhone($loginphone=null);
    $this->ajaxReturn($rs);
  }
  /**
  *用户注册add操作
  **/
  public function UserAdd()
  {
    $m = D('Mobile/Users');
    $rs = $m->UserAdd();
    $this->ajaxReturn($rs);
  }
  /**
  *用户登录操作
  **/
  public function UserLogin()
  {
    $m = D('Mobile/Users');
    $rs = $m->UserLogin();
    $this->ajaxReturn($rs);
  }
  /**
  *用户提出操作
  **/
  public function UserLogout()
  {
    session('Users',null);
    if(empty(session('Users'))){
      $rs['status'] = 1;
    }
    $this->ajaxReturn($rs);
  }
  /**
  *用户名修改操作
  **/
  public function doReName()
  {
    $m = D('Mobile/Users');
    $rs = $m->doReName();
    $this->ajaxReturn($rs);
  }
  /**
  *用户添加收货地址
  **/
  public function addAddress()
  {
    $m = D('Mobile/Address');
    $rs = $m->addAddress();
    $this->ajaxReturn($rs);
  }
  /**
  *用户收货地址
  **/
  public function userAddressList()
  {
    $m = D('Mobile/Address');
    $rs = $m->userAddressList();
    $this->ajaxReturn($rs);
  }
  /**
  *用户修改默认收货地址
  **/
  public function userIsDefault()
  {
    $m = D('Mobile/Address');
    $rs = $m->userIsDefault();
    $this->ajaxReturn($rs);
  }
  /**
  *用户删除收货地址
  **/
  public function delAddress()
  {
    $m = D('Mobile/Address');
    $rs = $m->delAddress();
    $this->ajaxReturn($rs);
  }
  /**
  *用户是否在线
  **/
  public function isgoLogin()
  {
    $s = session('Users');
    $rs['status']= empty($s)? -1: 1;
    $this->ajaxReturn($rs);
  }
  /**
  *用户默认地址
  **/
  public function getAddress()
  {
    $m = D('Mobile/Address');
    $rs = $m->getAddress();
    $this->ajaxReturn($rs);
  }
  /**
  *用户密码修改
  **/
  public function UserPws()
  {
    $m = D('Mobile/Users');
    $rs = $m->UserPws();
    $this->ajaxReturn($rs);
  }
}