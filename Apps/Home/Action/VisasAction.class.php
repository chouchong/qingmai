<?php
namespace Home\Action;
/**
 * ============================================================================
 * 签证制器
 */
class VisasAction extends BaseAction {
 /**
  *获取文章内容
  **/
  public function index()
  {
    $this->visa = D('Home/Visas')->getVisa();
    // var_dump($this->visa);
    $this->display('tpl/visa');
  }
}