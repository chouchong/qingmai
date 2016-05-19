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
    $this->daytime = date('Y-m', time());
    $this->ap = $m->getDap();
    $this->display('tpl/drives');
    // var_dump($this->ap);
 }

}