<?php
namespace Home\Action;
/**
 * ============================================================================
 * 门票制器
 */
class GoodsAction extends BaseAction {
 /**
  *获取文章内容
  **/
  public function index()
  {
    $this->good = D('Home/Goods')->goodsDetail();
    $this->daymtime = date('Y-m-d', time());
    $this->daytime = date('Y-m', time());
    $this->display('tpl/goods');
  }
}