<?php
 namespace Admin\Action;
/**
 * ============================================================================
 * 报名地点制器
 */
class PlaceAction extends BaseAction{
  /**
   * 跳到新增/编辑页面
   */
  public function Edit()
  {
    $this->isLogin();
    $this->checkPrivelege('bmdd_02');
    $rs=array();
    $m = D('Admin/Place');
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
    $this->checkPrivelege('bmdd_01');
    if(I('id')>0){
      $object = D('Admin/Place')->pageById();
    }else{
      $object=null;
    }
    $this->assign('object',$object);
    $this->view->display('/place/edit');
  }
  /**
  *报名地点列表
  **/
  public function index()
  {
    $this->isLogin();
    $this->checkPrivelege('bmdd_00');
    $page = D('Admin/Place')->queryByPage();
    $pager = new \Think\Page($page['total'],$page['pageSize']);// 实例化分页类 传入总记录数和每页显示的记录数
    $page['pager'] = $pager->show();
    $this->assign('Page',$page);
    $this->display('/place/list');
  }
  /**
  *删除
  **/
  public function del()
  {
    $rd=array();
    $this->isLogin();
    $this->checkAjaxPrivelege('bmdd_03');
    $m=D('Place')->where(array('placeId'=>I('id')))->delete();
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