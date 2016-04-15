<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 订单服务类
 */
class OrdersModel extends BaseModel {
  /**
  *自驾库存是否支付
  **/
  public function isNoPay()
  {
    $rd = array('status' => -1);
    $rs = M('order_goods')->field('drivestimeId')->where(array('orderId'=>I('orderId')))->find();
    $tp = M('drives_timeprice')->field('drivesStock')->where(array('timeId'=>$rs['drivestimeId']))->find();
    if($rs['drivestimeId'] >0){
      if($tp['drivesStock']<I('adultNum')){
        $rd['num'] = $tp['drivesStock'];
        $rd['status']=2;
      }else{
        $rd['status']=1;
      }
    }
    return $rd;
  }
  /**
  *修改订单支付方式
  **/
  public function editPayment()
  {
    $rd = array('status' => -1,'msg'=>'添加失败');
    $data['payType'] = I('payment');
    $rs = M('orders')->where(array('orderId'=>I('orderId')))->save($data);
    if(false !== $rs){
      $rd['status']=1;
    }
    return $rd;
  }
  /**
  *自驾订单修改
  **/
  public function editOrder()
  {
    $rd = array('status' => -1,'msg'=>'添加失败');
    $data['isRread'] = I('isRread')?1:0;
    $data['totalMoney'] = I('totalPrice');
    $data['zMoney'] = I('zMoney');
    $data['addressId'] = I('addressId');
    $data['isBigber'] = I('isBigber')?1:0;
    $data['orderDesc'] = I('Desc');
    $zcode = I("zcode");
    $rs = M('orders')->where(array('orderId'=>I('orderId')))->save($data);
    if(false !== $rs){
      if($zcode!=''){
        $str = explode(',',$zcode);
        foreach ($str as $v){
          if($v=='')continue;
          $zdata['couponsCode'] = $v;
          $zdata['orderId'] = I('orderId');
          $m = M('order_coupons');
          $m->add($zdata);
          $rd['status']=1;
        }
      }
      $rd['status']=1;
    }
    return $rd;
  }
  /**
  *自驾详情
  **/
  public function OrdersDetail()
  {
    $Sql = "SELECT o.orderId,o.childNum,o.childPrice,o.roomNum,o.roomPrice,o.adultNum,o.adultPrice,o.toTime,o.createTime,og.goodsName,o.orderNo,o.totalMoney,o.zMoney,og.drivesTo FROM __PREFIX__orders AS o LEFT JOIN __PREFIX__order_goods AS og ON o.orderId = og.orderId WHERE o.isPay = 0 AND o.orderId = ".I('orderId',3);
    $data= $this->query($Sql);
    return $data;
  }
  /**
  *自驾订单确定
  **/
  public function confirmDrives()
  {
    $Sql = "SELECT o.*,g.goodsName,g.drivesTo,g.goodsDrvivesTime,g.drivesType FROM __PREFIX__orders AS o LEFT JOIN __PREFIX__order_goods AS g ON o.orderId = g.orderId WHERE o.isPay = 0 AND o.goodsType = 1 AND o.orderId =".I('orderId',2);
    $data= $this->query($Sql);
    return $data;
  }
    /**
   * 添加订单
   */
  public function addOrder(){
    $m = M('orders');
    $daytime =I('selectday');
    $day =I('drivesDay',0);

    $data['totalMoney'] = I('totalPrice');  //1

    $data['childNum'] = I('childNum');
    $data['childPrice'] = I('childPrice');
    $data['roomNum'] = I('roomNum');
    $data['roomPrice'] = I('homePrice');
    $data['adultPrice'] = I('manPrice');
    $data['adultNum'] = I('manNum');

    $data['orderNo'] = 'E'.time();
    $data['goodsType'] = I('orderType');
    $data["createTime"] = date('Y-m-d H:i:s');
    $data['drivesDay'] = $day;
    $data['toTime'] = $daytime;
    $data['endTime'] = date("Y-m-d",strtotime("$daytime+$day day"));
    $data['orderStatus'] = 0;
    $data['userId'] = session('Users')['userId'];
    $data['addressId'] = I('addressId');//1

    $good['drivesId'] = I('drivesId');
    $good['goodsId'] = I('goodsId');
    $good['drivesType'] = I('drivesType');
    $good['drivesTo'] = I('drivesFrom','');
    $good['goodsAttrName'] = I('goodsAttrName');
    $good['goodsAttrPrice'] = I('goodsAttrPrice');
    $good['goodsAttrShop'] = I('goodsAttrShop');
    $good['goodsThums'] = I('goodsThums');
    $good['goodsName'] = I('goodsName');
    $good['goodsDrvivesTime'] = I('goodsDrvivesTime','',false);
    $good['drivestimeId'] = I('timeId');
    $rd = array('status' => -1,'msg'=>'添加失败');
    $rs = $m->add($data);
    if(false !== $rs){
      $good['orderId'] = $rs;
      M('order_goods')->add($good);
      $rd['status'] = 1;
      $rd['orderId'] = $rs;
    }
    return $rd;
  }
  /**
  *自驾详情
  **/
  public function OrdersList()
  {
    $pagesize = 5;
    $Sql = "SELECT o.isGo,o.isCar,o.orderStatus,o.goodsType,o.orderId,o.orderNo,o.drivesDay,o.childNum,o.childPrice,o.roomNum,o.roomPrice,o.adultNum,o.adultPrice,o.toTime,og.goodsName,o.orderNo,o.totalMoney,o.zMoney,og.drivesTo,o.createTime FROM __PREFIX__orders AS o LEFT JOIN __PREFIX__order_goods AS og ON o.orderId = og.orderId WHERE o.userId = ".session('Users')['userId']." ORDER BY o.orderId DESC LIMIT ".I('page',0)*$pagesize." , ".$pagesize;
    $data= $this->query($Sql);
    return $data;
  }
  /**
  *自驾出被保险人
  **/
  public function addCarLic()
  {
    $m = M('order_drivinglicences');
    $rd = array('status' => -1);
    $data['carzImg'] = I('carzImg');
    $data['carfImg'] = I('carfImg');
    $data['orderId'] = I('orderId');
    $data['userId'] = session('Users')['userId'];
    $id = $m->add($data);
    if($id){
      $o = M('orders')->field('isCar,isGo')->where(array('orderId'=>$data['orderId']))->find();
      if($o['isGo']>0){
        M('orders')->where(array('orderId'=>$data['orderId']))->save(array('orderStatus' =>2 , 'isCar'=>1));
      }
      M('orders')->where(array('orderId'=>$data['orderId']))->save(array('isCar'=>1));
      $rd['status'] = 1;
    }
    return $rd;
  }
}
?>