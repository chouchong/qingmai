<?php
 namespace Home\Model;
/**
 * ============================================================================
 * 支付服务类
 */
class PayModel extends BaseModel {
    /**
   * 添加报名时间
   */
  public function index(){
  	$sql = "select dt_orders.orderId,dt_orders.totalMoney,dt_orders.zMoney,dt_orders.childPrice,dt_orders.childNum,dt_orders.roomPrice,dt_orders.adultPrice,dt_orders.adultNum,dt_orders.roomNum,dt_orders.toTime,dt_order_goods.drivesTo,dt_order_goods.goodsName,dt_orders.goodsType,dt_orders.createTime from  dt_orders left join dt_order_goods on dt_order_goods.orderId=dt_orders.orderId where dt_orders.orderId =".I('orderId');
    return $this->query($sql);
  }
  //获取支付信息
  public function getInfo($orderId=0)
  {
  	M('orders')->where(array('orderId'=>$orderId))->save(array('orderNo' => 'E'.time()));
    return M('orders')->where(array('orderId'=>$orderId))->find();
  }
  //取回参数
  public function goPay()
  {
    $data['orderId'] = I('orderId');
    $data['values'] = I('values');
    return $data;
  }
  //取回信息
  public function getPayOrder($orderId)
  {
    $data = M('order_goods')->field('goodsName,orderId,goodsId,visaId')->where(array('orderId'=>$orderId))->find();
    $order['goodsName'] = $data['goodsName'];
    if($data['orderId'] > 0){
      $order['url'] = 'http://'.$_SERVER['HTTP_HOST'].'/z/'.$data['orderId'].'.html';
    }
    if($data['goodsId'] > 0){
      $order['url'] = 'http://'.$_SERVER['HTTP_HOST'].'/m/'.$data['goodsId'].'.html';
    }
    if($data['visaId'] > 0){
      $order['url'] = 'http://'.$_SERVER['HTTP_HOST'].'/v/'.$data['visaId'].'.html';
    }
    return $order;
  }
}
?>