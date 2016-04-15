<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 * 门票类型控制器
 */
class GoodsAttributesAction extends BaseAction{
	/**
	 * 跳到新增/编辑页面
	 */
  public function addAttr(){
    $m = D('Admin/GoodsAttributes');
    $this->isAjaxLogin();
    $this->checkAjaxPrivelege('splb_02');
    $rs = array();
    $rs = $m->insert();
    $this->ajaxReturn($rs);
  }
  /**
  *获取goods属性
  */
  public function findGoodsAttr(){
    $m = D('Admin/GoodsAttributes');
    $this->isAjaxLogin();
    $this->checkAjaxPrivelege('splb_02');
    $rs = $m->findGoodsAttr();
    $this->ajaxReturn($rs);
  }
  /**
  *删除goods属性
  */
  public function delAttr(){
    $m = D('Admin/GoodsAttributes');
    $this->isAjaxLogin();
    $this->checkAjaxPrivelege('splb_02');
    $rs = $m->delAttr();
    $this->ajaxReturn($rs);
  }
};
?>