<?php
namespace Api\Action;
/**
 * ============================================================================
 * Api控制器
 */
use Think\Controller;
class ApiAction extends Controller {
  public function __construct(){
    parent::__construct();
  }
  //mobile 首页自驾游
  public function drives()
  {
    $object  = D('Mobile/Drives')->pageByIndex();
    echo json_encode($object);
    die();
  }
  //mobile 手机首页广告
  public function getAdslist()
  {
    $object  = D('Mobile/Ads')->getAds($adPositionId = null,$adNum = null);
    echo json_encode($object);
    die();
  }
  //自驾时间价格
  public function getDtp()
  {
    $object = D('Mobile/Drives')->drivesTimePrices();
    echo json_encode($object);
    die();
  }
  /**
   * 订单列表
   */
  public function oList(){
    $data = D('Mobile/Orders')->OrdersList();
    $this->ajaxReturn($data);
  }
}