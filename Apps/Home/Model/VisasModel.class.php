<?php
 namespace Home\Model;
/**
 * ============================================================================
 * 签证服务类
 */
class VisasModel extends BaseModel {
    /**
   * 添加报名时间
   */
  public function getVisa(){
    return M('Visas')->where(array('visaId' =>I('visaId',1)))->find();
  }
}
?>