<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 自驾评价服务类
 */
class DrivesAppraisesModel extends BaseModel {
	 /**
	  * 分页列表
	  */
     public function queryByPage(){
     	$drivesName = I('drivesName');
        $m = M('drives_appraises');
	 			$sql = "select dp.*,u.userName,d.drivesName,d.drivesImg from dt_drives_appraises dp
		         left join dt_drives d on dp.drivesId=d.drivesId
		         left join dt_users u on u.userId=dp.userId
	 	        where d.drivesId=dp.drivesId";
	 	if($drivesName!='')$sql.=" and (d.drivesName like '%".$drivesName."%')";
	 	$sql.=" order by dp.id desc";
		$rs = $m->pageQuery($sql);
		return $rs;
	 }
	 /**
	  * 删除
	  */
	 public function del(){
	 	$rd = array('status'=>-1);
	 	$m = M('drives_appraises');
		$rs = $m->delete((int)I('id'));
		if($rs){
		   $rd['status']= 1;
		}
		return $rd;
	 }
};
?>