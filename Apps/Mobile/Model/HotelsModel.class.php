<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 酒店服务类
 */
class HotelsModel extends BaseModel {
    /**
   * 获取广告
   */
  public function getHotel(){
    $data = M('hotel')->where(array('hotelId' => I('HotelsId')))->find();
    return $data;
  }
}
?>