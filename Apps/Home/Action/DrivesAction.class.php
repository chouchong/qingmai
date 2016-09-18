<?php
namespace Home\Action;
/**
 * ============================================================================
 * 登录控制器
 */
use Tools\YunpianSms;
class DrivesAction extends BaseAction {
  /**
   * 跳到自驾游详情
   */
 public function diverDetail(){
 	  $m = D('Home/Drives');  
    $this->drive = $m->drivesDetail();
    $this->daymtime = date('Y-m-d', time());
    $this->daymmtime = date('Y-m-d', time() + (3 * 24 * 60 * 60));
    $this->daytime = date('Y-m', time());
    $this->drivesId = I('drivesId');
    $this->ap = $m->getDap();
    $this->username = empty(session('Users')['userName'])?1:session('Users')['userName'];
    $this->display('tpl/drives');
    // var_dump($this->username);
    // var_dump($this->drive['tp']);
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
  * 自驾添加评论
  */
  public function addComment(){
    $data = D('Home/Drives')->addComment();
    echo json_encode($data);
    die();
  }

}