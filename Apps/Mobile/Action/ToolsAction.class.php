<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 工具控制器
 */
use Think\Controller;
use Tools\YunpianSms;
class ToolsAction extends Controller {

  /**
  *短信发送
  **/
	public function smsSend()
  {
    $sms = new YunpianSms();
    $code = '';
    $charset = '1234567890';
    $_len = strlen($charset) - 1;
    for ($i = 0;$i < 6;++$i) {
        $code .= $charset[mt_rand(0, $_len)];
    }
    $m = D('Mobile/System')->loadConfigs();
    $data=array(
      'tpl_id'=>'8',
      //#code#=1234&#tel#=400-081-2798#company#=云片网
      'tpl_value'=>('#code#').'='.urlencode($code).'&'.('#tel#').'='.urlencode('4008627098').'&'.('#company#').'='.urlencode('要自在旅行'),
      'mobile'=>htmlspecialchars(I('userPhone','18206766729'))
    );
    $object = $sms->yp_send_tpl($data);
    //记录sms日志
    D('Mobile/Logs')->addSms(I('userPhone','18206766729'),$code);
    session('smscode',$code);
    echo json_encode($object);
    die();
  }
  public function smsTest()
  {
    $sms = new YunpianSms();
        // $data=array(
        //   'tpl_id'=>'1357521',
        //   'tpl_value'=>('#tel#').'='.urlencode($GLOBALS['CONFIG']['phoneNo']),
        //   'mobile'=>session('Users')['userPhone']
        // );
    $data=array(
      'tpl_id'=>'1357523',
      'tpl_value'=>('#tel#').'='.urlencode($GLOBALS['CONFIG']['phoneNo']),
      'mobile'=>session('Users')['userPhone']
    );
    $object = $sms->yp_send_tpl($data);
    var_dump($object);
  }
}