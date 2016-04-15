<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 订单控制器
 */
class OrdersAction extends BaseAction {
  /**
   * 自驾订单确定
   */
  public function confirmDrives(){
    $this->isLogin();
    $this->obj = D('Mobile/Orders')->confirmDrives()[0];
    $this->orderId = I('orderId',2);
    $this->view->display('/tpl/ConfirmDrives');
  }
  /**
   * 添加订单
   */
  public function addOrder(){
    $data = D('Mobile/Orders')->addOrder();
    $this->ajaxReturn($data);
  }
  /**
   * 自驾订单修改
   */
  public function editOrder(){
    $data = D('Mobile/Orders')->editOrder();
    $this->ajaxReturn($data);
  }
  /**
   * 自驾订单库存
   */
  public function isNoPay(){
    $data = D('Mobile/Orders')->isNoPay();
    $this->ajaxReturn($data);
  }
  /**
   * 用户订单
   */
  public function index(){
    $this->isLogin();
    $this->view->display('/tpl/order');
  }
  /**
   * 订单列表
   */
  public function OrdersList(){
    $data = D('Mobile/Orders')->OrdersList();
    $this->ajaxReturn($data);
  }
}