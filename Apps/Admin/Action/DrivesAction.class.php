<?php
 namespace Admin\Action;
/**
 * ============================================================================
 * 自驾控制器
 */
class DrivesAction extends BaseAction{
	/**
	 * 跳到新增/编辑页面
	 */
	public function toEdit(){
		$this->isLogin();
    $this->checkPrivelege('dplb_01');
		//获取酒店信息
    $this->hotels = D('Admin/Hotels')->queryByAll();
    //获取行程信息
    $this->articles = D('Admin/Articles')->queryByCatId(8);
    //获取景点信息
    $this->goods = D('Admin/Goods')->queryByAll();
    if(I('drivesId',0)>0){
      $this->object = D('Admin/Drives')->queryById();
    }
		$this->view->display('/drives/edit');
	}
	/**
	 * 新增/修改操作
	 */
	public function edit(){
		$this->isAjaxLogin();
		$m = D('Admin/Drives');
    	$rs = array();
    	if(I('id',0)>0){
    		$this->checkAjaxPrivelege('dplb_01');
    		$rs = $m->edit();
    	}else{
    		$this->checkAjaxPrivelege('dplb_01');
    		$rs = $m->insert();
    	}
    	$this->ajaxReturn($rs);
	}
	/**
	 * 删除操作
	 */
	public function del(){
		$this->isAjaxLogin();
		$this->checkAjaxPrivelege('ppgl_03');
		$m = D('Admin/Drives');
    	$rs = $m->del();
    	$this->ajaxReturn($rs);
	}
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
		$this->checkPrivelege('dplb_00');
		//获取地区信息
    $m = D('Admin/Drives');
    $page = $m->queryByPage();
    $pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
    $page['pager'] = $pager->show();
    $this->assign('Page',$page);
    $this->display("/drives/list");
	}
  /**
  *时间价格添加
  **/
  public function addTimePrice(){
    $this->isLogin();
    $m = D('Admin/Drives');
    $this->checkAjaxPrivelege('dplb_01');
    $rs = array();
    $rs = $m->addTimePrice();
    $this->ajaxReturn($rs);
  }
  /**
  *查询时间价格
  **/
  public function timePrice(){
    $this->isLogin();
    $this->checkAjaxPrivelege('dplb_01');
    $rs = array();
    $m = D('Admin/Drives');
    $rs = $m->timePrice();
    echo json_encode($rs);
  }
  /**
  *删除时间价格
  **/
  public function deltimePrice(){
    $this->isLogin();
    $this->checkAjaxPrivelege('dplb_01');
    $rs = array();
    $m = D('Admin/Drives');
    $rs = $m->deltimePrice();
    echo json_encode($rs);
  }
  /**
  *自驾禁用
  **/
  public function changeDrives(){
    $this->isLogin();
    $this->checkAjaxPrivelege('dplb_03');
    $rs = array();
    $m = D('Admin/Drives');
    $rs = $m->changeDrives();
    echo json_encode($rs);
  }

};
?>