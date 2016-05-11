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
  *用户名修改
  **/
  public function doReName($loginphone=null)
  {
    $m = M('users');
    $rs = array('status' => -1);
    $id = $m->where(array('userId'=>session('Users')['userId']))->save(array('userName'=>I('username')));
    if($id){
      $data = $m->where(array('userId'=>session('Users')['userId']))->find();
      $rs['status'] = 1;
      session('Users',$data);
    }
    return $rs;
  }
  /**
  *用户名修改
  **/
  public function UserPws()
  {
    $m = M('users');
    $rd = array('status' => -1,'msg'=>'修改错误');
    if(I('smscode')!=session('smscode')){
      $rd['status'] = -3;
      $rd['msg'] = "输入验证码有误";
      return $rd;
    }
    $data['loginPwd'] = md5('??'.I('phone').I('password'));
    $data['userPhone'] = I('phone');
    $user = $m->where(array('userPhone'=>$data['userPhone']))->find();
    if($this->checkEmpty($data)){
      $rs = $m->where(array('userId'=>$user['userId']))->save($data);
      if(false !== $rs){
        $rd['status']= 1;
      }
    }
    return $rd;
  }
  /**
  *用户名修改
  **/
  public function toCode()
  {
    $m = M('users');
    $rd = array('status' => -1,'msg'=>'修改错误');
    if(I('smscode')!=session('smscode')){
      $rd['status'] = -3;
      $rd['msg'] = "输入验证码有误";
      return $rd;
    }
    $data['userPhone'] = I('phone');
    $user = $m->where(array('userPhone'=>$data['userPhone']))->find();
    if($this->checkEmpty($data)){
      if(false !== $user){
        session('Users',$user);
        $rd['status']= 1;
      }
    }
    return $rd;
  }

}
?>