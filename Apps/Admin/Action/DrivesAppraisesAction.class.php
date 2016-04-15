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
		$this->checkPrivelege('sppl_00');
    $this->display("/drivesappraises/list");
	}
};
?>