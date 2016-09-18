<?php
namespace Home\Action;
/**
 * ============================================================================
 * 主页控制器
 */
use Tools\YunpianSms;
class IndexAction extends BaseAction {
  /**
   * 跳到首页面
   */
  public function index(){
  	$this->Ads = D('Mobile/Ads')->getAds(-1,1);
  	// var_dump($this->Ads);
   $this->drives=D('Home/Drives')->getDrivesList();
   $this->display('tpl/index');
  }
}