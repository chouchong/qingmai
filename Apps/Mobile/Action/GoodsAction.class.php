<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 门票控制器
 */
class GoodsAction extends BaseAction {
  /**
     * 跳到首页面
     */
  public function index(){
    $this->good = D('Mobile/Goods')->goodsDetail();
    $this->datetime = date('Y-m-d', time());
    $this->goodsId = I('goodsId');
    $this->drivesId = D('Mobile/Goods')->goodsFindDrivesId()['drivesId'];
    $this->view->display('/tpl/good');
  }
}