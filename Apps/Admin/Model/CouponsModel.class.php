<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 优惠码服务类
 */
class CouponsModel extends BaseModel {
    /**
    * 新增
    */
    public function insert(){
    	$rd=array('status'=>-1);
    	$data=array();
    	$data["couponsPrice"] = I("couponsPrice");
    	$data["couponsCode"] = I("couponsCode");
    	if($this->checkEmpty($data,true)){
            $m = M('coupons');
    		 $couponsId = $m->add($data);
    		 if($couponsId){
				$rd['status'] = 1;
    		}
    	}
        return $rd;
    }
      /**
    * 编辑
    */
    public function toedit(){
        $rd=array('status'=>-1);
    	$data=array();
    	$data["couponsPrice"]=I("couponsPrice");
        $data["isUse"] = I("isUse");
    	if($this->checkEmpty($data,true)){
    		 M('coupons')->where(array('couponsId'=>I("id")))->save($data);
    		 $rd['status']=1;
    	}
          return $rd;
    }
    /**
    *查询一条优惠码信息
    **/
    public function pageById(){
        return M('coupons')->where(array('couponsId'=>I("id")))->find();
    }
    /**
    *查询所有
    **/
    public function queryByPage(){
        $m = M('coupons');
                $sql = "select * FROM __PREFIX__coupons order by couponsId desc";
            return $m->pageQuery($sql);
    }
};
?>