<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 地址服务类
 */
class AddressModel extends BaseModel {
    /**
   * 添加地址
   */
  public function addAddress(){
    $m = M('user_address');
    $rd = array('status' => -1,'msg'=>'添加失败');
    $data['userName'] = I('name');
    $data['userPhone'] = I('phone');
    $data['userEmail'] = I('email');
    $data['address'] = I('address');
    if($this->checkEmpty($data)){
      $data['createTime'] = date('Y-m-d H:i:s');
      $data['userId'] = session('Users')['userId'];
      $data['isDefault'] = 1;
      $rs = $m->add($data);
      if(false !== $rs){
        //修改所有的地址为非默认
        $m->isDefault = 0;
        $m->where('userId='.(int)session('Users.userId')." and addressId!=".$rs)->save();
        $rd['status']= 1;
      }
    }
    return $rd;
  }
  /**
  *用户的收货地址
  **/
  public function userAddressList()
  {
   $data = M('user_address')->where('userId='.(int)session('Users.userId'))->select();
   return $data;
  }
  /**
  *用户修改默认收货地址
  **/
  public function userIsDefault()
  {
    $m = M('user_address');
    $rd = array('status' => -1,'msg'=>'添加失败');
    $addressId = I('addressId');
    $rs = $m->where('userId='.(int)session('Users.userId')." and addressId=".$addressId)->save(array('isDefault'=>1));
    if(false !== $rs){
      //修改所有的地址为非默认
      $m->isDefault = 0;
      $m->where('userId='.(int)session('Users.userId')." and addressId!=".$addressId)->save();
      $rd['status']= 1;
    }
    return $rd;
  }
  /**
  *用户删除收货地址
  **/
  public function delAddress()
  {
    $m = M('user_address');
    $rd = array('status' => -1,'msg'=>'删除失败');
    $addressId = I('addressId');
    $rs = $m->where("addressId=".$addressId)->delete();
    if(false !== $rs){
      $rd['status']= 1;
    }
    return $rd;
  }
  /**
  *用户默认地址
  **/
  public function getAddress()
  {
    $m = M('user_address');
    $data = $m->where(array('isDefault'=>1,'userId'=>session('Users')['userId']))->find();
    return $data;
  }
}
?>