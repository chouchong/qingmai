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
   $this->drives=D('Home/Drives')->getDrivesList();
   $this->display('tpl/index');
  }
}