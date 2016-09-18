<?php
namespace Home\Model;
/**
 * ============================================================================
 * 订单服务类
 */
class OrdersModel extends BaseModel {
  /**
   * 生成订单
   */
   public function addOrders(){
     $o = M('orders');
     $m = M('order_goods');
     $rs = array('status'=>-1);
     $dataDrives['orderNo'] = 'E'.time();
     $dataDrives['roomNum'] = I('roomNum');
     $dataDrives['roomPrice'] = I('homePrice');
     $dataDrives['childPrice'] = I('childPrice');
     $dataDrives['childNum'] = I('childNum');
     $dataDrives['adultPrice'] = I('manPrice');
     $dataDrives['adultNum'] = I('manNum');
     $dataDrives['totalMoney'] = I('totalPrice');
     $dataDrives['goodsType'] = I('orderType');
     $dataDrives['toTime'] = I('selectday');
     $dataDrives['endTime'] = I('selectday');
     $dataDrives['createTime'] = date('Y-m-d H:i:s');
     $dataDrives['userId'] = session('Users')['userId'];
     $dataDrives['isPay'] = 0;
     $dataGoods['drivesId'] = I('drivesId');
     $dataGoods['goodsThums'] = I('goodsThums');
     $dataGoods['drivesTo'] = I('drivesFrom');
     $dataGoods['drivesType'] = I('drivesType');
     $dataGoods['drivestimeId'] = I('timeId');
     $dataGoods['goodsDrvivesTime'] = I('goodsDrvivesTime');
     $dataGoods['goodsName'] = I('goodsName');
     $dataGoods['drivesDay'] = I('drivesDay');
     $dataGoods['drivesIsCross'] = I('drivesIsCross');
     if($this->checkEmpty($dataDrives,true)){
       $id = $o->add($dataDrives);
     }
     $dataGoods['orderId'] = $id;
    if($this->checkEmpty($dataGoods,true)){
       $rs['status'] = 1;
       $m->add($dataGoods);
       $rs['orderId'] = $id;
     }
     return $rs;
   }
  /**
   * 订单确认
   */
 public function orderConfirm(){
    $sql = "select * from dt_orders left join dt_order_goods on dt_orders.orderId=dt_order_goods.orderId where dt_orders.orderId=".I('orderId');
    return $this->query($sql);
 }
   /**
   * 获取默认联系人
   */
 public function getaddress(){
   $m = M('user_address');
   return $m->where(array('userId'=>session('Users')['userId'],'isDefault'=>1))->find();
 }
  /**
   * 订单确认提交信息
   */
 public function payNews(){
    $data['orderId'] = I('orderId');
    $codeData = I('codes');
    $rs = array('status'=>-1);
    $data['isRread'] = I('isRead');
    
    $orderId = I('orderId');
    $adata['userName'] = I('userAddress')['name'];
    $adata['userPhone'] = I('userAddress')['phone'];
    $adata['userEmail'] = I('userAddress')['email'];
    $adata['address'] = I('userAddress')['address'];
    if(I('userAddress') != null){
      if($this->checkEmpty($adata,true)){
        $adata['isDefault'] = 1;
        $adata['userId'] = session('Users')['userId'];
        $addressId = M('user_address')->add($adata);
        $data['addressId'] = $addressId;
        if($addressId){
         M('user_address')->where(array('userId'=>session('Users')['userId'],'addressId'=>array('neq',$addressId)))->save(array('isDefault'=>0));
        }
      }
    }else{
      $data['addressId'] = I('addressId');
    }    
    if($this->checkEmpty($data,true)){
      $data['isBigber'] = I('isBig');
      $data['orderDesc'] = I('orderDesc');
      $data['zMoney'] = I('codePrice');
      $data['totalMoney'] = I('totalPrice');
      M('orders')->where(array('orderId'=> $orderId))->save($data);
      if($codeData != ''){
        for ($i=0; $i < count($codeData); $i++) { 
          $cdata['orderId'] =  $orderId;
          $cdata['couponsCode'] = $codeData[$i];
          $crs = M('order_coupons')->add($cdata);   
       }
      } 
      $rs['status'] = 1;
      $rs['orderId'] = $orderId;   
    }
    return $rs;
 }
   /**
   * 优惠码
   */
 public function coupons(){
    $rs = array('status'=>-1,'codePrice'=>0);
    $coupons = M('coupons')->where(array('couponsCode'=>I('codes'),'isUse'=>-1))->find();
    $couponsCodes = M('order_coupons')->where(array('couponsCode'=>I('codes')))->find();
    if($coupons && !$couponsCodes){
          $rs['status'] = 1;
          $rs['codePrice'] = $coupons['couponsPrice'];
        }
    return $rs;
 }
  //订单列表
  public function OrdersList()
  {
    $pagesize = 5;
    $Sql = "SELECT o.isGo,o.isCar,o.orderStatus,o.goodsType,o.orderId,o.orderNo,og.drivesDay,o.childNum,o.childPrice,o.roomNum,o.roomPrice,o.adultNum,o.adultPrice,o.toTime,o.orderNo,o.totalMoney,o.zMoney,o.createTime,og.drivesTo,og.goodsName,og.goodsAttrName,og.goodsAttrShop,og.goodsThums,og.drivesIsCross FROM __PREFIX__orders AS o LEFT JOIN __PREFIX__order_goods AS og ON o.orderId = og.orderId WHERE o.addressId > 0 and o.userId = ".session('Users')['userId']." ORDER BY o.orderId DESC LIMIT ".I('page',0)*$pagesize." , ".$pagesize;
    $data= $this->query($Sql);
    return $data;
  }
   /**
  *修改订单支付方式
  **/
  public function editPayment()
  {
    $rd = array('status' => -1,'msg'=>'添加失败');
    switch (I('payment')){
      case 1:
        $data['payType'] = "微信";
        break;
      case 2:
        $data['payType'] = "银联";
        break;
      case 3:
        $data['payType'] = "支付宝";
        break;
      default:
        $data['payType'] = "其他";
        break;
    }
    if($data['payType'] == "其他"){
      $rd['status']=-1;
      return $rd;
    }
    $otp = M('order_goods')->field('drivestimeId')->where(array('orderId'=>I('orderId')))->find();
    $rs = M('orders')->where(array('orderId'=>I('orderId')))->save($data);
    $tp = M('drives_timeprice')->field('drivesStock')->where(array('timeId'=>$otp['drivestimeId']))->find();
    if($rs !== false){
      if($otp['drivestimeId'] > 0){
        if($tp['drivesStock']<I('adultNum')){
          $rd['num'] = $tp['drivesStock'];
          $rd['status']=2;
        }else{
          $rd['status'] = 1;
        }
      }else{
        $rd['status'] = 1;
      }
    }
    return $rd;
  }
  // 获取订单
  public static function getOrdersMan()
  {
    return M('orders')->field('orderId,orderNo,adultNum,childNum')->where(array('orderId'=>I('orderId')))->find();
  }
  //获取订单tp分页list
  public function getOrdersList()
  {
    $m = M('orders');
    $sql = "SELECT o.orderId,o.isGo,o.isCar,o.orderStatus,o.goodsType,o.orderId,o.orderNo,og.drivesDay,o.childNum,o.childPrice,o.roomNum,o.roomPrice,o.adultNum,o.adultPrice,o.toTime,o.orderNo,o.totalMoney,o.zMoney,o.createTime,og.drivesTo,og.goodsName,og.goodsAttrName,og.goodsAttrShop,og.goodsThums,og.drivesIsCross FROM dt_orders AS o LEFT JOIN dt_order_goods AS og ON o.orderId = og.orderId WHERE o.addressId>0 and o.userId = ".session('Users')['userId'];
    $sql.=" order by orderId desc";
    $page = $m->pageQuery($sql);
    return $page;
  }
  /**
  *订单添加保险人完成来修改订单状态
  **/
  public function addOUserIn()
  {
    $rd = array('status' => -1);
    //保存驾驶证
    $o = M('orders')->field('isCar,isGo')->where(array('orderId'=>I('orderId')))->find();
    if($o['isCar']>0){
      M('orders')->where(array('orderId'=>I('orderId')))->save(array('orderStatus' =>2 , 'isGo'=>1));
      $rd['status'] = 1;
    }else{
      M('orders')->where(array('orderId'=>I('orderId')))->save(array('isGo'=>1));
      $rd['status'] = 1;
    }
    //不保存驾驶证
    // $fs = M('orders')->where(array('orderId'=>I('orderId')))->save(array('orderStatus' =>2 , 'isGo'=>1));
    // if($fs !== false){
    //   $rd['status'] = 1;
    // }
    return $rd;
  }
  //获取驾驶证照片
  public function getCarLic()
  {
    $rd = array('status' => -1);
    if(I('orderId') != ''){
      $m = M('order_drivinglicences')->where(array('orderId'=>I('orderId')))->select();
      if($m){
         $rd['pic'] = $m;
         $rd['status'] = 0;
      }
      else{
         $rd['status'] = 1;
      }
    } 
    return $rd;
  }

}