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
    $this->orderId = I('orderId');
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
  /**
   * 订单保险人
   */
  public function getUserIn(){
    $data = D('Mobile/Orders')->getUserIn();
    $this->ajaxReturn($data);
  }
  /**
   * 订单添加保险人
   */
  public function addUserIn(){
    $data = D('Mobile/Orders')->addUserIn();
    $this->ajaxReturn($data);
  }
  /**
   * 订单添加保险人完成来修改订单状态
   */
  public function addOUserIn(){
    $data = D('Mobile/Orders')->addOUserIn();
    $this->ajaxReturn($data);
  }
}