<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 签证服务类
 */
class VisasModel extends BaseModel {
	 /**
	 * 新增门票
	 */
	public function insert(){
	 	$rd = array('status'=>-1);
		$data = array();
		$data["visaName"] = I("visaName");
		$data["visaType"] = I("visaType");
		$data["visaValidity"] = I("visaValidity");
		$data["visaCount"] = I("visaCount");
		$data["visaPrice"] = I("visaPrice");
		if($this->checkEmpty($data,true)){
			$data["createTime"] = date('Y-m-d H:i:s');
			$data["visaDesc"] = I("visaDesc",'',false);
			$data["visaTimeManagent"] = I("visaTimeManagent",'',false);
			$data["visaWay"] = I("visaWay",'',false);
			$m = M('visas');
			$visaId = $m->add($data);
			if(false !== $visaId){
				$rd['status']=1;
			}
		}
		return $rd;
	}
	/**
	 * 修改门票
	 */
	public function edit(){
	 	$rd = array('status'=>-1);
		$data = array();
		$visaId = (int)I("id",0);
		$data["visaName"] = I("visaName");
		$data["visaType"] = I("visaType");
		$data["visaValidity"] = I("visaValidity");
		$data["visaCount"] = I("visaCount");
		$data["visaPrice"] = I("visaPrice");
		$data["createTime"] = date('Y-m-d H:i:s');
		$m = M('visas');
		if($this->checkEmpty($data,true)){
			$data["visaDesc"] = I("visaDesc",'',false);
			$data["visaTimeManagent"] = I("visaTimeManagent",'',false);
			$data["visaWay"] = I("visaWay",'',false);
			$rs = $m->where('visaId='.$visaId)->save($data);
			if(false !== $rs){
				$rd['status']=1;
			}
		}
		return $rd;
	}
	/**
	  * 分页列表[获取已审核列表]
	  */
    public function queryByPage(){
    	$m = M('visas');
	 	$sql = "select visaId,visaName,visaPrice FROM __PREFIX__visas order by visaId desc";
		return $m->pageQuery($sql);
	 }
	 /**
	 *签证删除
	 */
	 public function delVisas(){
	 	$rd = array('status'=>-1);
	 	$m = M('visas');
	 	$rs=$m->where(array('visaId'=>I('visaId')))->delete();
	 	if(false !== $rs){
	 			$rd['status']=1;
	 	}
	 	return $rd;
	 }
	 /**
	 *获取签证
	 */
	 public function get(){

	 	$m = M('visas');
	 	//相册
	 	$rs = $m->find(I('id'));
		return $rs;
	 }
	 /**
	 *获取所有签证
	 */
    public function queryByAll(){
    	$m = M('visas');
		return $m->field('visaId,visaName')->order('visaId desc')->select();
	 }
};
?>