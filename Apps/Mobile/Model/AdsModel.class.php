<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 广告服务类
 */
class AdsModel extends BaseModel {
    /**
   * 获取广告
   */
  public function getAds($adPositionId = null,$adNum = null){
    $today = date("Y-m-d");
    $m = M('ads');
    $map['adStartDate'] = array('ELT',$today);
    $map['adEndDate'] = array('EGT',$today);
    $map['adPositionId'] = I('adPositionId',$adPositionId);
    $data = $m->field('adId,adName,adURL,adFile')->where($map)->order('adId desc')->limit(I('adNum',$adNum))->select();
    return $data;
  }
}
?>