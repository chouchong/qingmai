<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 * 签证控制器
 */
class VisasAction extends BaseAction{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toView(){
		$this->isLogin();
    	$this->checkPrivelege('dpqz_02');
		if((int)I('id',0)>0){
			$this->checkPrivelege('dpqz_03');
			$object = D('Admin/Visas')->get();
     		$this->assign('object',$object);
    	}else{
    	}
	$this->view->display('/visas/edit');
	}
	/**
	*签证添加/编辑
	*/
	public function toEdit(){
		$this->isLogin();
	    $this->checkAjaxPrivelege('dpqz_02');
	    $m = D('Admin/Visas');
	    $rs = array();
	    if((int)I('id',0)>0){
	      $rs = $m->edit();
	    }else{
	      $rs = $m->insert();
	    }
	    $this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
		$this->checkAjaxPrivelege('dpqz_01');
		$m = D('Admin/Visas');
		$page = $m->queryByPage();
	  	$pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
	  	$page['pager'] = $pager->show();
	  	$this->assign('Page',$page);
		$this->view->display('/visas/list');
	}
	/**
	 * 签证删除
	 */
    public function delVisas(){
    	$this->isAjaxLogin();
		$this->checkAjaxPrivelege('dpqz_04');
		$m = D('Admin/Visas');
		$rs = $m->delVisas();
		$this->ajaxReturn($rs);
	}
};
?>