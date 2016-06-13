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
  public function getCode($url)
  {
    $openid = session('openid');
    // 获取openid
    if($openid == '') {
      // 指定微信重定向后的地址
      $redirect_uri = urlencode($url);
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
  public function getOpenid($url)
  {
    if(session('openid')==''){
      $agent = $_SERVER['HTTP_USER_AGENT'];
      if(strpos($agent,"icroMessenger")){
        $this->getCode($url);
      }
      $WxPay = new WxPay();
      session('wxCode',I('code'));
      session('openid',$WxPay->getOpenid(I('code')));
    }
  }
  //获取当前url
  public function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
  }
}