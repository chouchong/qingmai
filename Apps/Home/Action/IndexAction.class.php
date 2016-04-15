<?php
namespace Home\Action;
/**
 * ============================================================================
 * ============================================================================
 * 控制器
 */
use Tools\YunpianSms;
class IndexAction extends BaseAction {
  /**
     * 跳到首页面
     */
  public function index(){
    // $class1 = array("John" => 100, "James" => 85);
    // $class2 = array("Micky" => 78, "John" => 45);
    // $classScores = array_merge($class1, $class2);
    // print_r($classScores);
    // $sms = new YunpianSms();
    // $data = array('mobile' => "18206766729", //请用自己的手机号代替
    //               'text'=>"【云片网】您的验证码是1234");
    // $arr = $sms->yp_send($data);
    // $code = '';
    // $charset = '1234567890';
    // $_len = strlen($charset) - 1;
    // for ($i = 0;$i < 6;++$i) {
    //     $code .= $charset[mt_rand(0, $_len)];
    // }
    // Object {phone: "18206766729", password: "456123", smscode: "456123", readMe: "true"}
    // I('readMe') = true;
    //  $this->daytime = date('Y-m-d', time());
    // print_r($this->daytime);
    // $daytime =I('day','2016-04-24');
    // $day =I('daydd',0);
    // echo   date("Y-m-d",strtotime("$daytime+$day day"));
//     $gallery = "222,111";
//     if($gallery!=''){
//       $str = explode(',',$gallery);
//       foreach ($str as $v){
// var_dump($v);
//       }
//       var_dump($str);
//     }
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    $o = M('orders');
    $data = $o->field('orderId')->where(array('orderNo'=>'E1460367064'))->find();
    var_dump($_SERVER['HTTP_HOST']);
  }
}