<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 支付服务类
 */
class PaysModel extends BaseModel {
  //获取支付信息
  public function getInfo($orderId=0)
  {
    return M('orders')->where(array('orderId'=>$orderId))->find();
  }
  //获取支付信息
  public function getInfoNo($orderNo='')
  {
    return M('orders')->field('orderNo,payType,totalMoney')->where(array('orderNo'=>$orderNo))->find();
  }
  //支付完成后修改订单
  public function editOrder($orderNo=0)
  {
    $o = M('orders');
    $data = $o->field('orderId,adultNum')->where(array('orderNo'=>$orderNo))->find();
    $good = M('order_goods')->field('goodsId,drivesId,drivestimeId')->where(array('orderId'=>$data['orderId']))->find();
    if($good['goodsId']>0){
      M('order_goods')->where('goodsId='.$good['goodsId'])->setInc('saleCount');
    }
    if($good['drivesId']>0){
      M('drives')->where('drivesId='.$good['drivesId'])->setInc('solaCount');
    }
    if($good['drivestimeId']>0){
      M('drives_timeprice')->where('timeId='.$good['drivestimeId'])->setDec('drivesStock',$data['adultNum']);
    }
    $coupons = M('order_coupons')->where(array('orderId'=>$data['orderId']))->select();
    if(false !== $coupons){
      for ($i=0; $i < count($coupons); $i++) {
        M('coupons')->where(array('couponsCode'=>$coupons[$i]['couponsCode']))->save(array('isUse' =>1));
      }
    }
    $o->where(array('orderNo' =>$orderNo))->save(array('orderStatus' =>1,'isPay'=>1));
  }
}
?>