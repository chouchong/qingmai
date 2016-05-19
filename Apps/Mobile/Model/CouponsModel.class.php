<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 优惠码服务类
 */
class CouponsModel extends BaseModel {
    /**
   * 优惠码是否使用
   */
  public function checkZcode(){
    $m = M('Coupons');
    $rd = array('status' => -1);
    $rs = $m->where(array('couponsCode'=>I('myZcode'),'isUse'=>-1))->find();
    $zcode = M('Order_coupons')->where(array('couponsCode'=>I('myZcode')))->find();
    if($rs!=false && $zcode==false){
      $rd['couponsPrice'] = $rs['couponsPrice'];
      $rd['status']=1;
    }
    return $rd;
  }
}
?>