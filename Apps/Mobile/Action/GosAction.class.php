<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 报名控制器
 */
class GosAction extends BaseAction {
  /**
   * 报名时间添加
   */
  public function addGoTime(){
    $data = D('Mobile/Gos')->addGoTime();
    $this->ajaxReturn($data);
  }
}