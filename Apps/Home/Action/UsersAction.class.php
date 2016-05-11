<?php
namespace Home\Action;
/**
 * ============================================================================
 * 登录控制器
 */
use Tools\YunpianSms;
class UsersAction extends BaseAction {
  /**
   * 跳到注册页面
   */
  public function register(){
   $this->display('tpl/register');
  }
    /**
   * 跳到登录页面
   */
    public function login(){
   $this->display('tpl/login');
  }
    /**
  *用户注册add操作
  **/
  public function UserAdd()
  {
    $m = D('Home/Users');
    $rs = $m->UserAdd();
    $this->ajaxReturn($rs);
  }
      /**
  *忘记密码操作
  **/
  public function setpassword()
  {
    $m = D('Home/Users');
    $rs = $m->setpassword();
    $this->ajaxReturn($rs);
  }
 /**
  *获取文章内容
  **/
  public function getContent()
  {
    $this->content = D('Home/Articles')->getArticlesContent();
    $this->display('tpl/content');
  }
   /**
  *用户没有注册直接验证码登录的时候验证用户是否注册
  **/
  public function getPhone()
  {
    $m = D('Home/Users');
    $rs = $m->getPhone();
    $this->ajaxReturn($rs);
  }
      /**
   * 密码登录
   */
    public function userLogin(){
      $m = D('Home/Users');
      $rs=$m->userLogin();
      $this->ajaxReturn($rs);
  }
  /**
   * 忘记密码
   */
    public function lostpassword(){
      $this->display('tpl/lostpassword');
  }
  /**
   * 退出登录
   */
    public function loginOut(){
      session('Users',null);
      $this->redirect("Home/Index/index");
  }
}