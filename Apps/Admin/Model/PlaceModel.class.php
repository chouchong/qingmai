<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 报名地点服务类
 */
class PlaceModel extends BaseModel {
    /**
    * 新增
    */
    public function insert(){
    	$rd=array('status'=>-1);
    	$data=array();
    	$data["placeName"] = I("placeName");
    	$data["placePhone"] = I("placePhone");
    	if($this->checkEmpty($data,true)){
            $m = M('Place');
    		 $PlaceId = $m->add($data);
    		 if($PlaceId){
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
    	$data["placeName"] = I("placeName");
        $data["placePhone"] = I("placePhone");
    	if($this->checkEmpty($data,true)){
    		 M('Place')->where(array('placeId'=>I("id")))->save($data);
    		 $rd['status']=1;
    	}
          return $rd;
    }
    /**
    *查询一条报名地点信息
    **/
    public function pageById(){
        return M('Place')->where(array('placeId'=>I("id")))->find();
    }
    /**
    *查询所有
    **/
    public function queryByPage(){
        $m = M('Place');
                $sql = "select * FROM __PREFIX__place order by PlaceId desc";
            return $m->pageQuery($sql);
    }
};
?>