<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 门票属性类
 */
class AttributesModel extends BaseModel {
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
     	$m = M('attributes');
		 	return $m->where('attrFlag=1')->order('attrSort asc,attrId asc')->select();
	 }
	 /**
	  * 下拉列表
	  */
     public function queryByList(){
     	 $catId = (int)I('catId');
     	 $m = M('attributes');
		 return $m->where('attrFlag=1 and catId='.$catId)->order('attrSort asc,attrId asc')->select();
	 }
};
?>