<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 * 自驾评价控制器
 */
class DrivesAppraisesAction extends BaseAction{
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
		$this->checkPrivelege('dppl_00');
    $m = D('Admin/DrivesAppraises');
    $page = $m->queryByPage();
    $pager = new \Think\Page($page['total'],$page['pageSize']);
    $page['pager'] = $pager->show();
    $this->assign('Page',$page);
    $this->display("/drivesappraises/list");
	}
  /**
   * 删除操作
   */
  public function del(){
    $this->isAjaxLogin();
    $this->checkAjaxPrivelege('dppl_02');
    $m = D('Admin/DrivesAppraises');
    $rs = $m->del();
    $this->ajaxReturn($rs);
  }
};
?>