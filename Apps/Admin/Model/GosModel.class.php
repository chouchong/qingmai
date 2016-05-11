<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 报名服务类
 */
class GosModel extends BaseModel {
    /**
   * 添加报名时间
   */
  public function queryByPage(){
    $m = M('go');
      $sql = "select * FROM __PREFIX__go order by goId desc";
    return $m->pageQuery($sql);
  }
   /**
   * 添加报名时间
   */
  public function goContact(){
    $rd = array('status'=>-1);
    $m = M('go');
    $data['isContact']= 1;
    $rs = $m->where("goId=".(int)I('goId',0))->save($data);
    if(false !== $rs){
      $rd['status']= 1;
    }
    return $rd;
  }
}
?>