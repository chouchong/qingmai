<?php
 namespace Mobile\Model;
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
    //Object {phone: "18206766729", password: "456123", smscode: "456123", readMe: "true"}
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
      if(false !== $rs){
        $rd['status']= 1;
        $data = array();
        $data['lastTime'] = date('Y-m-d H:i:s');
        $data['lastIP'] = get_client_ip();
        $m->where(" userId=".$rs)->data($data)->save();
        //记录登录日志
        D('Mobile/Logs')->addUserLogins($rs);
      }
    }
    return $rd;
  }
  /**
  *用户登录操作
  **/
  public function UserLogin()
  {
    $m = M('users');
    $rd = array('status'=>-1);
    $userPhone = I('phone');
    $userPwd = I('password');
    $data = $m->where(array('userPhone'=>$userPhone))->find();
    if($data['loginPwd']==md5('??'.$userPhone.$userPwd)){
      session('Users',$data);
      $rd['status'] = 1;
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

}
?>