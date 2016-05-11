<?php
 namespace Home\Model;
/**
 * ============================================================================
 * 日志服务类
 */
class LogsModel extends BaseModel {
    /**
   * 日志sms
   */
  public function addSms($phone,$code)
  {
    $data = array();
    $data["createTime"] = date('Y-m-d H:i:s');
    $data["smsIP"] = get_client_ip();
    $data['smsCode'] = $code;
    $data['smsPhoneNumber'] = $phone;
    $sms = M('log_sms')->field('smsId')->where(array('smsPhoneNumber'=>$phone))->find();
    if($sms['smsId']>0){
      M('log_sms')->where(array('smsId'=>$sms['smsId']))->save($data);
    }else{
      M('log_sms')->add($data);
    }
  }
  /**
  *登录日志
  **/
  public function addUserLogins($rs)
  {
    $data = array();
    $data["userId"] = $rs;
    $data["loginTime"] = date('Y-m-d H:i:s');
    $data["loginIp"] = get_client_ip();
    M('log_user_logins')->add($data);
  }
}
?>