<?php
 namespace Admin\Action;
/**
 * ============================================================================
 * 属性类型控制器
 */
class AttributeCatsAction extends BaseAction{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
    $this->checkPrivelege('ppgl_00');
		$this->isLogin();
	    $m = D('Admin/AttributeCats');
    	$object = array();
    	if((int)I('id',0)>0){
    		$object = $m->get();
    	}else{
    		$object = $m->getModel();
    	}
    	$this->assign('object',$object);
    	$this->assign('umark',"AttributeCats");
		$this->view->display('/attributecats/edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		$this->isAjaxLogin();
    $this->checkAjaxPrivelege('ppgl_00');
		$m = D('Admin/AttributeCats');
    	$rs = array();
    	if((int)I('id',0)>0){
    		$rs = $m->edit();
    	}else{
    		$rs = $m->insert();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
    $this->checkAjaxPrivelege('ppgl_00');
		$this->isAjaxLogin();
		$m = D('Admin/AttributeCats');
    	$rs = $m->del();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
    $this->checkPrivelege('ppgl_00');
		$m = D('Admin/AttributeCats');
		$list = $m->queryByList();
    	$this->assign('List',$list);
    	$this->assign('umark',"AttributeCats");
      $this->display("/attributecats/list");
	}
	/**
	 * 获取属性分类列表
	 */
	public function queryByList(){
    $this->checkAjaxPrivelege('ppgl_00');
		//获取门票属性分类信息
		$m = D('Admin/AttributeCats');
		$list = $m->queryByList();
		$rs = array('status'=>1,'list'=>$list);
    	$this->ajaxReturn($rs);
	}
};
?>