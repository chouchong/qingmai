<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 优惠码控制器
 */
class CouponsAction extends BaseAction {
  /**
   * 报名时间添加
   */
  public function checkZcode(){
    $data = D('Mobile/Coupons')->checkZcode();
    $this->ajaxReturn($data);
  }
}