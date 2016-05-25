<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 签证控制器
 */
class VisasAction extends BaseAction {
  /**
   * 报名时间添加
   */
  public function index(){
  	$this->visa = D('Mobile/Visas')->getVisa();
  	$this->drivesId = I('drivesId');
    $this->view->display('/tpl/visa');
  }
}