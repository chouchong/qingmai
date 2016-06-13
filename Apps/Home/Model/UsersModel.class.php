<?php
 namespace Home\Model;
/**
 * ============================================================================
 * 用户服务类
 */
class UsersModel extends BaseModel {
  /**
  *用户的手机号码验证
  **/
  public function regPhone($loginphone=null)
  {
    $m = M('users');
    $rs = array('status' => -1);
    $id = $m->where(array('userPhone'=>I('userPhone',$loginphone)))->select();
    if($id){
      $rs['status'] = 1;
    }
    return $rs;
  }
  /**
  *用户注册add操作
  **/
  public function UserAdd()
  {
    $m = M('users');
    $rd = array('status'=>-1,'msg'=>"注册失败,请重新注册");
    $data = array();
    if(I('smscode')!=session('smscode')){
      $rd['status'] = -3;
      $rd['msg'] = "输入验证码有误";
      return $rd;
    }
    $crs = $this->regPhone(I('phone'));
    if($crs['status']==1){
      $rd['status'] = -4;
      $rd['msg'] = "手机号码被注册";
      return $rd;
    }
    $data['loginPwd'] = md5('??'.I('phone').I('password'));
    $data['userPhone'] = I('phone');
    $data['createTime'] = date('Y-m-d H:i:s');
    $data['userFlag'] = 1;
    $data['isRead'] = I('readMe')?1:0;
    if($this->checkEmpty($data)){
      $rs = $m->add($data);
      $rd['status'] = 1;
      $rd['msg'] = "注册成功";
    }
    return $rd;
  }
  /**
  *忘记密码操作
  **/
  public function setpassword()
  {
    $m = $m = M('users');
    $rd = array('status'=>-1,'msg'=>"找回密码失败，请重试");
    if(I('smscode')!=session('smscode')){
      $rd['status'] = -3;
      $rd['msg'] = "输入验证码有误";
      return $rd;
    }
    $data['loginPwd'] = md5('??'.I('phone').I('password'));
    $data['userPhone'] = I('phone');
    $data['lastTime'] = date('Y-m-d H:i:s');
    if($this->checkEmpty($data)){
      $rs = $m->where(array('userPhone'=>I('phone')))->save($data);
      $rd['status'] = 1;
      $rd['msg'] = "密码设置成功";
    }
    return $rd;
  }
  /**
  *用户没有注册直接验证码登录的时候验证用户是否注册
  **/
  public function getPhone()
  {
    $m = M('users');
    $rs = array('status' => -1);
    $id = $m->where(array('userPhone'=>I('phone')))->select();
    if($id){
      $rs['status'] = 1;
    }
    return $rs;
  }
  /**
   * 用户密码或验证码登录
   */
    public function userLogin(){
    $m = M('users');
    $l = M('log_sms');
    $rd = array('status'=>-1);
    $userPhone = I('phone');
    $userPwd = I('password');
    $loginType = I('loginType');
    $data['lastTime'] = date('Y-m-d H:i:s');
    $data["lastIP"] = get_client_ip();
    $userData['userPhone'] = $userPhone;
    $userData['userPwd'] = $userPwd;
    $userData['loginType'] = $loginType;
    $result = $m->where(array('userPhone'=>$userPhone))->find();
    if($this->checkEmpty($userData)){
        if($loginType==1){
          if($result['loginPwd']==md5('??'.$userPhone.$userPwd)){
            session('Users',$result);
            $m->where(array('userPhone'=>$userPhone))->save($data);
            $rd['status'] = 1;
          }
        }
        if($loginType==0){
          $sms = $l->where(array('smsPhoneNumber'=>$userPhone))->find();
          if($sms['smsCode']==$userPwd){
            session('Users',$result);
            $rd['status'] = 1;
          }
        }
    }
    return $rd;
  }
  /**
  *用户昵称修改
  **/
  public function doReName()
  { 
    $m = M('users');
    $rs = array('status' => -1);
    if($this->checkEmpty(I('newName'),true)){
      $id = $m->where(array('userId'=>session('Users')['userId']))->save(array('userName'=>I('newName')));
      if($id){
        $data = $m->where(array('userId'=>session('Users')['userId']))->find();
        $rs['status'] = 1;
        session('Users',$data);
      }
    }
    return $rs;
  }
    /**
  *联系人
  **/
  public function userset()
  { 
    $m = M('user_address');
    $rs = array('status' => -1);
    $data['userName'] = I('name');
    $data['userPhone'] = I('phone');
    $data['userEmail'] = I('email');
    $data['address'] = I('address');
    $data['isDefault'] = 1;
    $data['userId'] = session('Users')['userId'];
    $data['createTime'] = date('Y-m-d H:i:s');
    if($this->checkEmpty($data,true)){
       $id = $m->where(array('userId'=>session('Users')['userId']))->add($data);
       if($id){
       $m->where(array('userId'=>session('Users')['userId'],'addressId'=>array('neq',$id)))->save(array('isDefault'=>0));
       $rs['status'] = 1;
     }
    }
    return $rs;
  }
     /**
  *联系人展示
  **/
  public function usershow()
  { 
    return M('user_address')->field('userName,userPhone,userEmail,address,addressId,isDefault')->where(array('userId'=>session('Users')['userId']))->order('addressId desc')->select();
  }
   /**
  *默认联系人
  **/
  public function userDefault()
  { 
    $rs = array('status' => -1);
    $m = M('user_address');
    $id = $m->where(array('addressId'=>I('addressId'),'userId'=>session('Users')['userId']))->save(array('isDefault'=>1));
    if($id){
     $m->where(array('userId'=>session('Users')['userId'],'addressId'=>array('neq',I('addressId'))))->save(array('isDefault'=>0));
     $rs['status'] = 1;
    }
    return $rs;
  }
  /**
  *删除联系人
  **/
  public function userAddressRemove()
  { 
    $rs = array('status' => -1);
    $m = M('user_address');
    $id = $m->where(array('addressId'=>I('addressId'),'userId'=>session('Users')['userId']))->delete();
     if($id){
      $rs['status'] = 1;
     }
    return $rs;
  }
}
?>