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
    $d = D('Home/Drives');
    $data = $d->getDrivesList();
    $this->ajaxReturn($data);
  }
}