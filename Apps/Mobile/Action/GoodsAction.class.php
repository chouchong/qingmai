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
    $this->daymtime= date('Y-m-d', time() + (1 * 24 * 60 * 60));
    $this->goodsId = I('goodsId');
    $this->drivesId = I('drivesId');
    // var_dump($this->day1time);
    $this->view->display('/tpl/good');
  }
}