<?php
 namespace Admin\Action;
/**
 * ============================================================================
 * 优惠码制器
 */
class CouponsAction extends BaseAction{
  /**
   * 跳到新增/编辑页面
   */
  public function Edit()
  {
    $this->isLogin();
    $this->checkPrivelege('yhgl_02');
    $rs=array();
    $m = D('Admin/Coupons');
    if(I("id")>0){
      $rs=$m->toedit();
    }
    else{
      $rs=$m->insert();  
    }
    $this->ajaxReturn($rs);
  }
    /**
   * 新增/编辑
   */
  public function toView()
  {
    $this->isLogin();
    $this->checkPrivelege('yhgl_01');
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $strlen = 26; 
    while($length > $strlen){ 
    $str .= $str; 
    $strlen += 26; 
    } 
    $str = str_shuffle($str);
    if(I('id')>0){
      $object = D('Admin/Coupons')->pageById();
    }else{
      $object['couponsCode'] = substr($str,0,1).time();
    }
    $this->assign('object',$object);
    $this->view->display('/coupons/edit');
  }
  /**
  *优惠码列表
  **/
  public function index()
  {
    $this->isLogin();
    $this->checkPrivelege('yhgl_00');
    $page = D('Admin/Coupons')->queryByPage();
    $pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
    $page['pager'] = $pager->show();
    $this->assign('Page',$page);
    $this->display('/coupons/list');
  }
  /**
  *删除
  **/
  public function del()
  {
    $rd=array();
    $this->isLogin();
    $this->checkAjaxPrivelege('yhgl_03');
    $m=D('coupons')->where(array('couponsId'=>I('id')))->delete();
    if($m){
     $rd['status']=1;
    }  
    else{
      $rd['status']=-1;
    }
    $this->ajaxReturn($rd);
  }
};
?>