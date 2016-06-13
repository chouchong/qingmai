<?php
namespace Home\Action;
/**
 * ============================================================================
 * 订单服务类
 */
use Tools\YunpianSms;
class OrdersAction extends BaseAction {
  //用户订单列表
  public function order()
  {
    $this->isLogin();
    $m = D('Home/Orders');
    $page=$m->getOrdersList();
    $page['total'] = M('Orders')->where("addressId > 0 and userId = ".session('Users')['userId'])->count();
    $pager = new \Think\Page($page['total'],$page['pageSize']);
    $this->pager = $pager->show();
    $this->row = $page['root'];
    $this->display('/tpl/orders');
  }
  /**
  *用户默认地址
  **/
  public function OrdersList(){
    $data = D('Home/Orders')->OrdersList();
    $this->ajaxReturn($data);
  }
  /**
   * 生成订单
   */
 public function addOrders(){
   $rs = D('Home/Orders')->addOrders();
   $this->ajaxReturn($rs);
 }
   /**
   * 订单确认
   */
 public function orderConfirm(){
  $this->orders =  D('Home/Orders')->orderConfirm()[0];
  $this->user = D('Home/Orders')->getaddress();
  $this->display('tpl/orderConfirm');
 }
   /**
   * 订单确认提交信息
   */
 public function payNews(){
   $rs = D('Home/Orders')->payNews();
   $this->ajaxReturn($rs);
 }
    /**
   * 优惠码
   */
 public function coupons(){
   $rs = D('Home/Orders')->coupons();
   $this->ajaxReturn($rs);
 }
 //自驾订单出行的驾驶证
  public function orderCar()
  {
    $this->isLogin();
    $this->row = D('Home/Orders')->getOrdersMan();
    $this->display('/tpl/ordersCar');
  }
  //自驾订单出行的保险人
  public function orderInfo()
  {
    $this->isLogin();
    $this->row = D('Home/Orders')->getOrdersMan();
    // var_dump($this->row);
    $this->display('/tpl/ordersInfo');
  }
  /**
   * 订单添加保险人完成来修改订单状态
   */
  public function addOUserIn(){
    $data = D('Home/Orders')->addOUserIn();
    $this->ajaxReturn($data);
  }
  /**
   * 订单添加保险人完成来修改订单状态
   */
  public function ordersComment(){
    $this->isLogin();
    $d= D('Home/Drives');
    $this->d = $d->getInfo();
    $this->display('/tpl/comment');
  }
}