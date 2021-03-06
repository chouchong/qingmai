<?php
 namespace Admin\Action;;
/**
 * ============================================================================
 * 订单控制器
 */
class OrdersAction extends BaseAction{
	/**
	 * 分页查询
	 */
	public function index(){
		$this->isLogin();
		$this->checkAjaxPrivelege('ddlb_00');
		$m = D('Admin/Orders');
    $page=$m->orderList();
    $pager = new \Think\Page($page['total'],$page['pageSize']);
    $page['pager'] = $pager->show();
    $this->assign('page',$page);
    $this->display("/orders/list");
	}
	/**
	  * 获取订单驾驶证照片
	  */
     public function getCarPic(){
     	$m=D('Admin/Orders');
        $this->ajaxReturn($m->getCarPic());
     }
     /**
	  * 获取被保险人详情
	 */
     public function getInsureds(){
        $m=D('Admin/Orders');
        $this->ajaxReturn($m->getInsureds());
     }
    /**
	  * 获取定单详情
	 */
     public function getDetailModel(){
        $m=D('Admin/Orders');
        $this->ajaxReturn($m->getDetailModel()[0]);
     }
   /**
    * 获取地址详情
   */
     public function addresDetail(){
        $m=D('Admin/Orders');
        $this->ajaxReturn($m->addresDetail());
     }

    /**
	 * 退款分页查询
	 */
	public function queryRefundByPage(){
		$this->isLogin();
		$this->checkAjaxPrivelege('tk_00');
		//获取地区信息
		$m = D('Admin/Areas');
		$this->assign('areaList',$m->queryShowByList(0));
		$m = D('Admin/Orders');
    	$page = $m->queryRefundByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize']);
    	$pager->setConfig('header','件门票');
    	$page['pager'] = $pager->show();
    	$this->assign('Page',$page);
    	$this->assign('shopName',I('shopName'));
    	$this->assign('orderNo',I('orderNo'));
    	$this->assign('isRefund',I('isRefund',-1));
    	$this->assign('areaId1',I('areaId1',0));
    	$this->assign('areaId2',I('areaId2',0));
    	$this->assign('areaId3',I('areaId3',0));
      $this->display("/orders/list_refund");
	}
	/**
	 * 查看订单详情
	 */
	public function toView(){
		$this->isLogin();
		$this->checkPrivelege('ddlb_00');
		$m = D('Admin/Orders');
		if(I('id')>0){
			$object = $m->getDetail();
			$this->assign('object',$object);
		}
		$this->assign('referer',$_SERVER['HTTP_REFERER']);
		$this->display("/orders/view");
	}
    /**
	 * 查看订单详情
	 */
	public function toRefundView(){
		$this->isLogin();
		$this->checkPrivelege('tk_00');
		$m = D('Admin/Orders');
		if(I('id')>0){
			$object = $m->getDetail();
			$this->assign('object',$object);
		}
		$this->assign('referer',$_SERVER['HTTP_REFERER']);
		$this->display("/orders/view");
	}
	/**
	 * 跳到退款页面
	 */
	public function toRefund(){
		$this->isLogin();
		$this->checkPrivelege('tk_04');
		$m = D('Admin/Orders');
	    if(I('id')>0){
			$object = $m->get();

			$this->assign('object',$object);
		}
		$this->display("/orders/refund");
	}
	/**
	 * 报名
	 */
    public function goTime(){
		$this->isLogin();
		$this->checkPrivelege('ddlb_00');
		$m = D('Admin/Gos');
    	$page = $m->queryByPage();
    	$pager = new \Think\Page($page['total'],$page['pageSize']);
    	$page['pager'] = $pager->show();
    	$this->assign('Page',$page);
		$this->display("/go/list");
	}
	/**
	 * 联系报名
	 */
    public function goContact(){
    	$m=D('Admin/Gos');
        $this->ajaxReturn($m->goContact());
	}
	//订单是否操作
	public function goDDDo()
	{
		$m=D('Admin/Orders');
        $this->ajaxReturn($m->goDDDo());
	}
};
?>