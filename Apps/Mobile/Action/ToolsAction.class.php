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
      'tpl_value'=>('#code#').'='.urlencode($code).'&'.urlencode('#company#').'='.urlencode('要自在旅行').'&'.urlencode('#tel#').'='.urlencode($m['phoneNo']),
      'mobile'=>htmlspecialchars(I('userPhone'))
    );
    $object = $sms->yp_send_tpl($data);
    //记录sms日志
    D('Mobile/Logs')->addSms(I('userPhone'),$code);
    session('smscode',$code);
    echo json_encode($object);
    die();
  }
}