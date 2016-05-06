<?php
namespace Admin\Model;
/**
 * ============================================================================
 * 门票标签服务类
 */
class GoodsLabelsModel extends BaseModel {
    /**
	  * 新增
	  */
	 public function insertLabels(){
	 	$rd = array('status'=>-1);
		$data = array();
		$data["name"] = I("name");
		if($this->checkEmpty($data,true)){
		  $data["isShow"] = (int)I("isShow",0);
			$data["sort"] = (int)I("Sort",0);
			$m = M('Labels');
			$rs = $m->add($data);
			if($rs){
				$rd['status']= 1;
			}
		}
		return $rd;
	 }
     /**
	  * 修改
	  */
	 public function editLabels(){
	 	$rd = array('status'=>-1);
	 	$id = (int)I("id",0);
		$data = array();
		$data["name"] = I("name");
	    if($this->checkEmpty($data)){
	    	$data["isShow"] = (int)I("isShow",0);
				$data["sort"] = (int)I("Sort",0);
				$m = M('Labels');
			$rs = $m->where("id=".(int)I('id'))->save($data);
			if(false !== $rs){
				$rd['status']= 1;
			}
		}
		return $rd;
	 } 
	 /**
	  * 修改名称
	  */
	 public function editName(){
	 	$rd = array('status'=>-1);
	 	$id = (int)I("id",0);
		$data = array();
		$data["name"] = I("name");
	    if($this->checkEmpty($data)){
	    	$m = M('Labels');
				$rs = $m->where("id=".(int)I('id'))->save($data);
			if(false !== $rs){
				$rd['status']= 1;
			}
		}
		return $rd;
	 }
	 /**
	  * 获取指定对象
	  */
     public function get($id){
	 		$m = M('Labels');
			return $m->where("id=".(int)$id)->find();
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('Labels');
	     $rs = $m->select();
		 return $rs;
	  }
	  /**
	  * 分页列表[获取已审核列表]
	  */
    public function queryByPage(){
    	$m = M('Labels');
	 	$sql = "select * FROM __PREFIX__labels order by sort asc";
		return $m->pageQuery($sql);
	 }
	 /**
	 *标签删除
	 */
	 public function delLabels(){
	 	$rd = array('status'=>-1);
	 	$m = M('Labels');
	 	$rs=$m->where(array('id'=>I('id')))->delete();
	 	if(false !== $rs){
	 			$rd['status']=1;
	 	}
	 	return $rd;
	 }
};
?>