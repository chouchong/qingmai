<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 酒店服务类
 */
class HotelsModel extends BaseModel {
	 /**
	 * 新增门票
	 */
	public function insert(){
	 	$rd = array('status'=>-1);
		$data = array();
		$data["hotelName"] = I("hotelName");
		$data["hotelImg"] = I("hotelImg");
		// $data["hotelThumbs"] = I("hotelThumbs");
		// $data["hotelEnglishName"] = I("hotelEnglishName");
		$data["hotelPhone"] = I("hotelPhone");
		$data["hotelStar"] = I("hotelStar");
		$data["hotelType"] = I("hotelType");
		$data["hotelnetwork"] = I("hotelnetwork");
		$data["hotelRoomArea"] = I("hotelRoomArea");
		$data["hotelBedSize"] = I("hotelBedSize");
		$data["hotelAddress"] = I("hotelAddress");
		// $data["hotelEnglishAddress"] = I("hotelEnglishAddress");
		$data["hotelpark"] = I("hotelpark");
		$data["hotelTntime"] = I("hotelTntime");
		$data["hotelFromtime"] = I("hotelFromtime");
		if($this->checkEmpty($data,true)){
			$data["createTime"] = date('Y-m-d H:i:s');
			$data["hotelService"] = I("hotelService",'',false);
			$data["hotelcomplex"] = I("hotelcomplex",'',false);
			$data["hotelRoomfacilities"] = I("hotelRoomfacilities",'',false);
			$data["hotelDesc"] = I("hotelDesc",'',false);
			$data["hotelContent"] = I("hotelContent",'',false);
			$data["hotelActivity"] = I("hotelActivity",'',false);
			$m = M('hotel');
			$hotelId = $m->add($data);
			if(false !== $hotelId){
				M('hotel_gallerys')->where(array('hid' => $hotelId))->delete();
				//保存相册
				$gallery = I("gallery");
				if($gallery!=''){
					$str = explode(',',$gallery);
					foreach ($str as $k => $v){
						if($v=='')continue;
						$str1 = explode('@',$v);
						$data = array();
						$data['hid'] = $hotelId;
						$data['hotelImg'] = $str1[0];
						$data['hotelThumbs'] = $str1[1];
						$m = M('hotel_gallerys');
						$m->add($data);
					}
				}
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
		$hotelId = (int)I("id",0);
		$data["hotelName"] = I("hotelName");
		$data["hotelImg"] = I("hotelImg");
		// $data["hotelThumbs"] = I("hotelThumbs");
		// $data["hotelEnglishName"] = I("hotelEnglishName");
		$data["hotelPhone"] = I("hotelPhone");
		$data["hotelStar"] = I("hotelStar");
		$data["hotelType"] = I("hotelType");
		$data["hotelnetwork"] = I("hotelnetwork");
		$data["hotelRoomArea"] = I("hotelRoomArea");
		$data["hotelBedSize"] = I("hotelBedSize");
		$data["hotelAddress"] = I("hotelAddress");
		// $data["hotelEnglishAddress"] = I("hotelEnglishAddress");
		$data["hotelpark"] = I("hotelpark");
		$data["hotelTntime"] = I("hotelTntime");
		$data["hotelFromtime"] = I("hotelFromtime");
		$data["createTime"] = date('Y-m-d H:i:s');
		$m = M('hotel');
		if($this->checkEmpty($data,true)){
			$data["hotelService"] = I("hotelService",'',false);
			$data["hotelcomplex"] = I("hotelcomplex",'',false);
			$data["hotelRoomfacilities"] = I("hotelRoomfacilities",'',false);
			$data["hotelDesc"] = I("hotelDesc",'',false);
			$data["hotelContent"] = I("hotelContent",'',false);
			$data["hotelActivity"] = I("hotelActivity",'',false);
			$rs = $m->where('hotelId='.$hotelId)->save($data);
			if(false !== $rs){
				M('hotel_gallerys')->where(array('hid' => $hotelId))->delete();
				//保存相册
				$gallery = I("gallery");
				if($gallery!=''){
					$str = explode(',',$gallery);
					foreach ($str as $k => $v){
						if($v=='')continue;
						$str1 = explode('@',$v);
						$data = array();
						$data['hid'] = $hotelId;
						$data['hotelImg'] = $str1[0];
						$data['hotelThumbs'] = $str1[1];
						$m = M('hotel_gallerys');
						$m->add($data);
					}
				}
				$rd['status']=1;
			}
		}
		return $rd;
	}
	/**
	  * 分页列表[获取已审核列表]
	  */
    public function queryByPage(){
    	$m = M('hotel');
	 			$sql = "select hotelId,hotelName,hotelType FROM __PREFIX__hotel order by hotelId desc";
			return $m->pageQuery($sql);
	 }
	 /**
	 *酒店删除
	 */
	 public function delHotels(){
	 	$rd = array('status'=>-1);
	 	$m = M('hotel');
	 	$rs=$m->where(array('hotelId'=>I('hotelId')))->delete();
	 	if(false !== $rs){
	 			$rd['status']=1;
	 	}
	 	return $rd;
	 }
	 /**
	 *获取酒店
	 */
	 public function get(){

	 	$m = M('hotel');
	 	//相册
	 	$rs = $m->find(I('id'));
		$rs['gallery'] = M('hotel_gallerys')->where('hid='.I('id'))->select();
		return $rs;
	 }
	 /**
	 *获取所有酒店
	 */
    public function queryByAll(){
    	$m = M('hotel');
			return $m->field('hotelId,hotelName')->order('hotelId desc')->select();
	 }
};
?>