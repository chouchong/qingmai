<?php
namespace Home\Model;
/**
 * ============================================================================
 * 商品服务类
 */
class GoodsModel extends BaseModel {
	/**
   * 获取门票详情
   */
  public function goodsDetail(){
    $m = M('goods');
    $data = $m->where(array('goodsId' => I('goodsId')))->find();
    $data['attrPrice'] = M('goods_attributes')->field('attrVal,attrPrice')->where(array('goodsId' => I('goodsId'),'attrId'=>1))->select();
    $data['attrfd'] = M('goods_attributes')->field('attrVal')->where(array('goodsId' => I('goodsId'),'attrId'=>2))->select();
    $goodsLaSql = 'SELECT l.name FROM __PREFIX__goods_labels AS gl LEFT JOIN __PREFIX__labels AS l ON gl.labelsId = l.id WHERE gl.goodsId = '.I('goodsId');
    $data['labels'] = $this->query($goodsLaSql);
    return $data;
  }
     /**
  *提交门票信息
  **/
  public function goodsNews(){
   $rs = array('status'=>-1);
   if(!I('addressId')){
      $data['userName'] = I('aName');
      $data['userPhone'] = I('phone');
      $data['userEmail'] = I('email');
      $data['address'] = I('address');
      $data['isDefault'] = 1;
      $data['userId'] = session('Users')['userId'];
      $data['createTime'] = date('Y-m-d h:i:s');
      if($this->checkEmpty($data,true)){
        $addressId = M('user_address')->add($data);
        $odata['addressId'] = $addressId;
        M('user_address')->where(array('userId'=>session('Users')['userId'],'addressId'=>array('neq',$addressId)))->save(array('isDefault'=>0));
         $rs['status'] = 1;
      }
    }else{
        $odata['addressId'] = I('addressId');
    }
    $odata['toTime'] = I('toTime');
    $odata['userId'] = session('Users')['userId'];
    $odata['adultNum'] = I('adultNum');
    $odata['adultPrice'] = I('ticketPrice');
    $odata['childNum'] = I('childNum');
    $odata['childPrice'] = I('childPrice');
    $odata['totalMoney'] = I('ticketPrice')*I('adultNum') + I('childPrice')*I('childNum');
    $odata['goodsType'] = 2;
    $odata['createTime'] = date('Y-m-d h:i:s');
    $odata['orderNo'] = 'E'.time();
    $orderId = M('orders')->add($odata);
    if($orderId > 0){
       $gdata['goodsId'] = I('goodsId');
       $gdata['goodsName'] = I('goodsName');
       $gdata['goodsThums'] = I('goodsThums');
       $gdata['goodsAttrName'] = I('ticketVal');
       $gdata['goodsAttrPrice'] = I('ticketPrice');
       $gdata['goodsAttrShop'] = I('ticketFendian');
       $gdata['orderId'] = $orderId;
       M('order_goods')->add($gdata);
       $rs['status'] = 2;
       $rs['orderId'] = $orderId;
    }
    return $rs;
  }
}