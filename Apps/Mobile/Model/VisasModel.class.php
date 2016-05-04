<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 签证服务类
 */
class VisasModel extends BaseModel {
    /**
   * 添加报名时间
   */
  public function getVisa(){
    return M('Visas')->where(array('visaId' =>I('visaId')))->find();
  }
}
?>