<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 * 门票标签控制器
 */
class GoodsLabelsAction extends BaseAction{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		  $this->isLogin();
	    $m = D('Admin/GoodsLabels');
    	$object = array();
    	if(I('id',0)>0){
    		$this->checkPrivelege('spbq_02');
    		$this->object = $m->get(I('id',0));
    	}else{
    	}
		  $this->view->display('/goodslabels/edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		$this->isAjaxLogin();
		$m = D('Admin/GoodsLabels');
    	$rs = array();
    	if(I('id',0)>0){
    		$this->checkAjaxPrivelege('spbq_02');
    		$rs = $m->editLabels();
    	}else{
    		$this->checkAjaxPrivelege('spbq_01');
    		$rs = $m->insertLabels();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 修改名称
	 */
	public function editName(){
		$this->isAjaxLogin();
		$m = D('Admin/GoodsLabels');
    	$rs = array('status'=>-1);
    	if(I('id',0)>0){
    		$this->checkAjaxPrivelege('spbq_02');
    		$rs = $m->editName();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function delLabels(){
		$this->isAjaxLogin();
		$this->checkAjaxPrivelege('spbq_03');
		$m = D('Admin/GoodsLabels');
    	$rs = $m->delLabels();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
		$this->checkPrivelege('spbq_00');
		$m = D('Admin/GoodsLabels');
    $page = $m->queryByPage();
    $pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
    $page['pager'] = $pager->show();
    $this->assign('Page',$page);
    $this->display("/goodslabels/list");
	}
	/**
	 * 列表查询
	 */
    public function queryByList(){
    	$this->isAjaxLogin();
		$m = D('Admin/GoodsLabels');
		$list = $m->queryByList(I('id'));
		$rs = array();
		$rs['status'] = 1;
		$rs['list'] = $list;
		$this->ajaxReturn($rs);
	}
    /**
	 * 显示门票是否显示/隐藏
	 */
	 public function editiIsShow(){
	 	$this->isAjaxLogin();
	 	$this->checkAjaxPrivelege('spbq_02');
	 	$m = D('Admin/GoodsLabels');
		$rs = $m->editiIsShow();
		$this->ajaxReturn($rs);
	 }
};
?>