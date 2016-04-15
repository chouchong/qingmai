<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 * 酒店控制器
 */
class HotelsAction extends BaseAction{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toView(){
		$this->isLogin();
    $this->checkPrivelege('dpjd_02');
		if((int)I('id',0)>0){
			$this->checkPrivelege('dpjd_03');
			$object = D('Admin/Hotels')->get();
     	$this->assign('object',$object);
    }else{
    }
    $this->view->display('/hotels/edit');
	}
	/**
	*酒店添加/编辑
	*/
	public function toEdit(){
		$this->isLogin();
    $this->checkAjaxPrivelege('dpjd_02');
    $m = D('Admin/Hotels');
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
		$this->checkAjaxPrivelege('dpjd_01');
		$m = D('Admin/Hotels');
		$page = $m->queryByPage();
  	$pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
  	$page['pager'] = $pager->show();
  	$this->assign('Page',$page);
		$this->view->display('/hotels/list');
	}
	/**
	 * 酒店删除
	 */
    public function delHotels(){
    	$this->isAjaxLogin();
			$this->checkAjaxPrivelege('dpjd_04');
			$m = D('Admin/Hotels');
			$rs = $m->delHotels();
			$this->ajaxReturn($rs);
	}
};
?>