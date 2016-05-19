<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 控制器
 */
class IndexAction extends BaseAction {
  /**
     * 跳到首页面
     */
  public function index(){
    C('TOKEN_ON',false);
    $this->object  = D('Mobile/Drives')->pageByIndex();
    $this->Ads  = D('Mobile/Ads')->getAds(-2,1);
    $this->view->display('/tpl/list');
  }
  /**
  *400签证
  **/
  public function visa(){
    $this->isLogin();
    $this->object  = D('Mobile/Drives')->pageByIndex();
    $this->Ads  = D('Mobile/Ads')->getAds(-2,1);
    $this->view->display('/tpl/list');
  }
  /**
     * 自驾加载
     */
  public function getDList(){
    $this->ajaxReturn(D('Mobile/Drives')->pageByIndex());
  }
}