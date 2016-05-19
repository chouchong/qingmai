<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 基础控制器
 */
use Think\Controller;
use Org\Pay\WxPay;
class BaseAction extends Controller {
	public function __construct(){
		parent::__construct();
    $m = D('Mobile/System');
    $GLOBALS['CONFIG'] = $m->loadConfigs();
    $this->assign('CONF',$GLOBALS['CONFIG']);
    $this->assign('Users',session('Users'));
    $this->getOpenid();
	}
  /**
   * 登录操作验证
   */
  public function isLogin(){
    $s = session('Users');
      if(empty($s))$this->redirect("Users/gologin");
  }
  /**
  *微信授权
  **/
  public function getCode()
  {
    $openid = session('openid');
    // 获取openid
    if($openid == '') {
      // 指定微信重定向后的地址
      $redirect_uri = urlencode('http://gozztrip.com/Mobile');
      // 微信重定向
      $url = 'https://open.weixin.qq.com/connect/oauth2/authorize' .
        '?appid=' . C('wx_config.APPID') .
        '&redirect_uri=' . $redirect_uri .
        '&response_type=code' .
        '&scope=snsapi_base' .
        '&state=STATE' .
        '#wechat_redirect';
      echo "<script language=javascript>window.location.href='".$url."'</script>";
    }
  }
  /**
  * 获取openid
  */
  public function getOpenid()
  {
    if(session('openid')==''){
      $agent = $_SERVER['HTTP_USER_AGENT'];
      if(strpos($agent,"icroMessenger")){
        $this->getCode();
      }
      $WxPay = new WxPay();
      session('wxCode',I('code'));
      session('openid',$WxPay->getOpenid(I('code')));
    }
  }
}