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
    $this->daymtime = date('Y-m', time());
    $this->drive=D('Mobile/Drives')->drivesDetail();
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
    $Pay = D('Mobile/Pays');
    C('TOKEN_ON',false);
    $this->Orders = $Pay->getInfo(I('orderId'));
    $this->view->display('/tpl/comment');
  }
  /**
  * 自驾添加评论
  */
  public function addComment(){
    $data = D('Mobile/Drives')->addComment();
    echo json_encode($data);
    die();
  }
}