<?php
 namespace Home\Model;
/**
 * ============================================================================
 * 签证服务类
 */
class VisasModel extends BaseModel {
    /**
   * 添加报名时间
   */
  public function getVisa(){
    return M('Visas')->where(array('visaId' =>I('visaId',1)))->find();
  }
  /**
   * 签证用户信息
   */
  public function visaUserNews(){
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
    $odata['userId'] = session('Users')['userId'];
    $odata['adultNum'] = I('manNum');
    $odata['adultPrice'] = I('visaPrice');
    $odata['totalMoney'] = I('visaPrice')*I('manNum');
    $odata['goodsType'] = 3;
    $odata['createTime'] = date('Y-m-d h:i:s');
    $odata['orderNo'] = 'E'.time();
    $orderId = M('orders')->add($odata);
  	if($orderId > 0){
  	   $gdata['visaId'] = I('visaId');
  	   $gdata['goodsName'] = I('visaName');
  	   $gdata['orderId'] = $orderId;
  	   M('order_goods')->add($gdata);
       $rs['status'] = 2;
       $rs['orderId'] = $orderId;
  	}
    return $rs;
  }
}
?>