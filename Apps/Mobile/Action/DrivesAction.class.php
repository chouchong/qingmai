<?php
namespace Mobile\Action;
/**
 * ============================================================================
 * 自驾控制器
 */
class DrivesAction extends BaseAction {
  /**
  * 跳到首页面
  */
  public function index(){
    $this->drivesId =I('drivesId');
    $this->daytime = date('Y-m-d', time());
    $this->drive=D('Mobile/Drives')->drivesDetail();
    // var_dump($this->drive['tp']);
    $this->view->display('/tpl/drive');
  }
  /**
  * 自驾详情
  */
  public function drivesDetail(){
    $data = D('Mobile/Drives')->drivesDetail();
    echo json_encode($data);
    die();
  }
  /**
  *自驾报名地点时间
  */
  public function goPlace(){
    $data = D('Mobile/Places')->goPlace();
    echo json_encode($data);
    die();
  }
  /**
  *自驾里的酒店详情
  */
  public function getHotel(){
    $data = D('Mobile/Hotels')->getHotel();
    echo json_encode($data);
    die();
  }
  /**
  *时间详情
  */
  public function getTp(){
    $data = D('Mobile/Drives')->getTp();
    echo json_encode($data);
    die();
  }
   /**
    *获取自驾某些
    **/
  public function getDrivesfield()
  {
    $data = D('Mobile/Drives')->getDrivesfield();
    echo json_encode($data);
    die();
  }
  /**
  * 自驾评论
  */
  public function dComment(){
    $this->isLogin();
    $this->Orders = D('Mobile/Orders')->OrdersDetail()[0];
    $this->view->display('/tpl/comment');
  }
}