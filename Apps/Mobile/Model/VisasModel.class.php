<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 签证服务类
 */
class VisasModel extends BaseModel {
    /**
   * 签证
   */
  public function getVisa(){
    return M('Visas')->where(array('visaId' =>I('visaId')))->find();
  }
  /**
   * 签证获取哪个自驾的签证
   */
  public function visaFindDrivesId(){
    return M('drives')->field('drivesId')->where(array('drivesVisa' =>I('visaId')))->find();
  }
}
?>