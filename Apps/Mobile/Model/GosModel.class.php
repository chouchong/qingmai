<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 报名服务类
 */
class GosModel extends BaseModel {
    /**
   * 添加报名时间
   */
  public function addGoTime(){
    $m = M('go');
    $rd = array('status' => -1,'msg'=>'添加失败');
    $data['goTime'] = I('goTime');
    $data['goNum'] = I('goNum');
    $data['goName'] = I('goName');
    $data['goPhone'] = I('goPhone');
    if($this->checkEmpty($data)){
      $rs = $m->add($data);
      if(false !== $rs){
        $rd['status']= 1;
      }
    }
    return $rd;
  }
}
?>