<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 时间报名服务类
 */
class PlacesModel extends BaseModel {
    /**
   * 获取报名地点
   */
  public function goPlace(){
    $data = M('place')->limit(3)->select();
    return $data;
  }
}
?>