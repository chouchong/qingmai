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
    $ris = M('order_goods')->field('drivestimeId')->where(array('orderId'=>I('orderId')))->find();
    $tp = M('drives_timeprice')->field('drivesStock')->where(array('timeId'=>$ris['drivestimeId']))->find();
    if($ris['drivestimeId'] >0){
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
    $address = M('order_goods')->field('drivestimeId')->where(array('orderId'=>I('orderId')))->find();
    $rs = M('orders')->where(array('orderId'=>I('orderId')))->save($data);
    $tp = M('drives_timeprice')->field('drivesStock')->where(array('timeId'=>$address['drivestimeId']))->find();
    if($address['drivestimeId'] >0){
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
  *自驾订单修改
  **/
  public function editOrder()
  {
    $data['addressId'] = I('addressId');
    $rd = array('status' => -1,'msg'=>'添加失败');
    if(session('Users')['userId']!=null){
      $data['userId'] = session('Users')['userId'];
    }
    if(I('isUser')!=null){
      $m = M('user_address');
      $userA['userName'] = I('isUser')['name'];
      $userA['userPhone'] =I('isUser')['phone'];
      $userA['userEmail'] = I('isUser')['email'];
      $userA['address'] = I('isUser')['address'];
      if($this->checkEmpty($userA)){
        $userA['createTime'] = date('Y-m-d H:i:s');
        if($data['userId']){
          $userA['userId'] = $data['userId'];
          $userA['isDefault'] = 1;
        }
        $rs = $m->add($userA);
        if(false !== $rs){
          //修改所有的地址为非默认
          $m->isDefault = 0;
          $m->where('userId='.(int)session('Users.userId')." and addressId!=".$rs)->save();
          $rd['status']= 1;
          $data['addressId'] =$rs;
        }
      }
    }
    $data['isRread'] = I('isRread')?1:0;
    $data['totalMoney'] = I('totalPrice');
    $data['zMoney'] = I('zMoney');
    $data['isBigber'] = I('isBigber')?0:1;
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
    $dataO= $this->query($Sql);
    $data['userId'] = (int)session('Users.userId');
    $address = M('orders')->field('addressId,userId')->where(array('orderId'=>I('orderId')))->find();
    $rs = M('orders')->where(array('orderId'=>I('orderId')))->save($data);
    if($address['userId']==null){
      M('user_address')->where("addressId=".$address['addressId'])->save(array('isDefault'=>1,'userId'=>$data['userId']));
      M('user_address')->where('userId='.$data['userId']." and addressId!=".$address['addressId'])->save(array('isDefault'=>0));
    }
    return $dataO;
  }
  /**
  *自驾订单确定
  **/
  public function confirmDrives()
  {
    $Sql = "SELECT o.*,g.drivesDay,g.goodsName,g.drivesTo,g.goodsDrvivesTime,g.drivesType FROM __PREFIX__orders AS o LEFT JOIN __PREFIX__order_goods AS g ON o.orderId = g.orderId WHERE o.isPay = 0 AND o.goodsType = 1 AND o.orderId =".I('orderId',2);
    $data= $this->query($Sql);
    return $data;
  }
  /**
   * 添加订单
   */
  public function addOrder(){
    $m = M('orders');
    $data['totalMoney'] = I('totalPrice');  //1
    $daytime =I('selectday');
    $day =I('drivesDay');
    $data['childNum'] = I('childNum');
    $data['childPrice'] = I('childPrice');
    $data['roomNum'] = I('roomNum');
    $data['roomPrice'] = I('homePrice');
    $data['adultPrice'] = I('manPrice');
    $data['adultNum'] = I('manNum');

    $data['orderNo'] = 'E'.time();
    $data['goodsType'] = I('orderType');
    $data["createTime"] = date('Y-m-d H:i:s');
    
    $data['toTime'] = $daytime;
    $data['endTime'] = $daytime;
    $data['orderStatus'] = 0;
    if(session('Users')['userId']!=null){
      $data['userId'] = session('Users')['userId'];
    }
    $rd = array('status' => -1,'msg'=>'添加失败');
    $data['addressId'] = I('addressId');//1
    $good['drivesId'] = I('drivesId');
    $good['goodsId'] = I('goodsId');
    $good['drivesType'] = I('drivesType');
    $good['drivesDay'] = $day;
    $good['drivesTo'] = I('drivesFrom','');
    $good['goodsAttrName'] = I('goodsAttrName');
    $good['goodsAttrPrice'] = I('goodsAttrPrice');
    $good['goodsAttrShop'] = I('goodsAttrShop');
    $good['goodsThums'] = I('goodsThums');
    $good['goodsName'] = I('goodsName');
    $good['goodsDrvivesTime'] = I('goodsDrvivesTime','',false);
    $good['drivestimeId'] = I('timeId');
    if(I('isUser')!=null){
      $userA['userName'] = I('isUser')['name'];
      $userA['userPhone'] =I('isUser')['phone'];
      $userA['userEmail'] = I('isUser')['email'];
      $userA['address'] = I('isUser')['address'];
      if($this->checkEmpty($userA)){
        $userA['createTime'] = date('Y-m-d H:i:s');
        if($data['userId']){
          $userA['userId'] = $data['userId'];
        }
        $userA['isDefault'] = 1;
        $address = M('user_address')->add($userA);
        if(false !== $address){
          //修改所有的地址为非默认
          M('user_address')->isDefault = 0;
          M('user_address')->where('userId='.(int)session('Users.userId')." and addressId!=".$address)->save();
          $rd['status']= 3;
          $data['addressId'] =$address;
        }
      }
    }
    $rs = $m->add($data);
    if(false !== $rs){
      $good['orderId'] = $rs;
      M('order_goods')->add($good);
      $rd['status'] = 1;
      $rd['orderId'] = $rs;
      $data = null;
      $good = null;
    }
    return $rd;
  }
  /**
  *自驾详情
  **/
  public function OrdersList()
  {
    $pagesize = 5;
    $Sql = "SELECT o.isGo,o.isCar,o.orderStatus,o.goodsType,o.orderId,o.orderNo,og.drivesDay,o.childNum,o.childPrice,o.roomNum,o.roomPrice,o.adultNum,o.adultPrice,o.toTime,og.goodsName,o.orderNo,o.totalMoney,o.zMoney,og.drivesTo,o.createTime FROM __PREFIX__orders AS o LEFT JOIN __PREFIX__order_goods AS og ON o.orderId = og.orderId WHERE o.userId = ".session('Users')['userId']." ORDER BY o.orderId DESC LIMIT ".I('page',0)*$pagesize." , ".$pagesize;
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
        $rd['status'] = 1;
      }else{
        M('orders')->where(array('orderId'=>$data['orderId']))->save(array('isCar'=>1));
        $rd['status'] = 1;
      }
    }
    return $rd;
  }
  /**
  *自驾出保险人信息
  **/
  public function getUserIn()
  {
    return M('order_insureds')->where(array('orderId' =>I('orderId')))->select();
  }
  /**
  *自驾出添加保险人信息
  **/
  public function addUserIn()
  {
    $rd = array('status' => -1);
    $data['orderId'] = I('orderId');
    $data['userName'] = I('userName');
    $data['userCard'] = I('userCard');
    $data['sex'] = I('sex');
    $data['userId'] = session('Users')['userId'];
    if(I('insuredId')>0){
      $ed = M('order_insureds')->where(array('insuredId' =>I('insuredId')))->save($data);
      if($ed !== false){
        $rd['status'] = 1;
      }
    }else{
      $ed = M('order_insureds')->add($data);
      if($ed !== false){
        $rd['status'] = 1;
      }
    }
    return $rd;
  }
  /**
  *订单添加保险人完成来修改订单状态
  **/
  public function addOUserIn()
  {
    $rd = array('status' => -1);
    $o = M('orders')->field('isCar,isGo')->where(array('orderId'=>I('orderId')))->find();
    if($o['isCar']>0){
      M('orders')->where(array('orderId'=>I('orderId')))->save(array('orderStatus' =>2 , 'isGo'=>1));
      $rd['status'] = 1;
    }else{
      M('orders')->where(array('orderId'=>I('orderId')))->save(array('isGo'=>1));
      $rd['status'] = 1;
    }
    return $rd;
  }
  /**
  *订单取消
  **/
  public function orDel()
  {
    $rd = array('status' => -1);
    $ed = M('orders')->where(array('orderId'=>I('orderId')))->delete();
    if($ed !== false){
      M('orders')->where(array('orderId'=>I('orderId')))->delete();
      M('order_coupons')->where(array('orderId'=>I('orderId')))->delete();
      M('order_goods')->where(array('orderId'=>I('orderId')))->delete();
      $rd['status'] = 1;
    }
    return $rd;
  }
}
?>