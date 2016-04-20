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
    $this->view->display('/tpl/visa');
  }
}