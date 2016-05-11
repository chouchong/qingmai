<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 门票服务类
 */
class GoodsModel extends BaseModel {
	/**
	 * 获取门票信息
	 */
	 public function get(){
	 	$m = M('goods');
	 	$id = (int)I('id',0);
		$goods = $m->where("goodsId=".$id)->find();
		//相册
		$m = M('goods_gallerys');
		$goods['gallery'] = $m->where('goodsId='.$id)->select();
		$labelsIds = array();
    $labelsgoods = M('goods_labels')->where(array('goodsId'=>$id))->select();
      for ($i=0; $i <count($labelsgoods); $i++) {
        $labelsIds[]=$labelsgoods[$i]['labelsId'];
      }
    $goods['labelsIds']=implode(",", $labelsIds);
		return $goods;
	 }
	 /**
	  * 分页列表[获取待审核列表]
	  */
     public function queryPenddingByPage(){
        $m = M('goods');
        $shopName = I('shopName');
     	$goodsName = I('goodsName');
     	$areaId1 = (int)I('areaId1',0);
     	$areaId2 = (int)I('areaId2',0);
     	$goodsCatId1 = (int)I('goodsCatId1',0);
     	$goodsCatId2 = (int)I('goodsCatId2',0);
     	$goodsCatId3 = (int)I('goodsCatId3',0);
	 	$sql = "select g.*,gc.catName,sc.catName shopCatName,p.shopName from __PREFIX__goods g 
	 	      left join __PREFIX__goods_cats gc on g.goodsCatId3=gc.catId 
	 	      left join __PREFIX__shops_cats sc on sc.catId=g.shopCatId2,__PREFIX__shops p 
	 	      where goodsStatus=0 and goodsFlag=1 and p.shopId=g.shopId and g.isSale=1";
	 	if($areaId1>0)$sql.=" and p.areaId1=".$areaId1;
	 	if($areaId2>0)$sql.=" and p.areaId2=".$areaId2;
	 	if($goodsCatId1>0)$sql.=" and g.goodsCatId1=".$goodsCatId1;
	 	if($goodsCatId2>0)$sql.=" and g.goodsCatId2=".$goodsCatId2;
	 	if($goodsCatId3>0)$sql.=" and g.goodsCatId3=".$goodsCatId3;
	 	if($shopName!='')$sql.=" and (p.shopName like '%".$shopName."%' or p.shopSn like '%".$shopName."%')";
	 	if($goodsName!='')$sql.=" and (g.goodsName like '%".$goodsName."%' or g.goodsSn like '%".$goodsName."%')";
	 	$sql.="  order by goodsId desc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 分页列表[获取已审核列表]
	  */
     public function queryByPage(){
        $m = M('goods');
     	$goodsName = I('goodsName');
	 	$sql = "select g.*,gc.catName from __PREFIX__goods g
	 	      left join __PREFIX__goods_cats gc on g.goodsCatId3=gc.catId
	 	      where goodsStatus=1 and goodsFlag=1 and g.isSale=1";
	 	if($goodsName!='')$sql.=" and (g.goodsName like '%".$goodsName."%')";
	 	$sql.="  order by goodsId desc";
		return $m->pageQuery($sql);
	 }
	 /**
	  * 获取列表
	  */
	  public function queryByList(){
	     $m = M('goods');
	     $sql = "select * from __PREFIX__goods order by goodsId desc";
		 return $m->find($sql);
	  }
	  /**
	  * 获取列表
	  */
	  public function queryByAll(){
     	$m = M('goods');
     	return $m->field('goodsId,goodsName')->where(array('goodsStatus'=>1))->order('goodsId desc')->select();
	  }
	 /**
	  * 修改门票状态
	  */
	 public function changeGoodsStatus(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	$id = (int)I('id',0);
	 	$m->goodsStatus = (int)I('status',0);
		$rs = $m->where('goodsId='.$id)->save();
		if(false !== $rs){
			$sql = "select goodsName,userId from __PREFIX__goods g,__PREFIX__shops s where g.shopId=s.shopId and g.goodsId=".$id;
			$goods = $this->query($sql);
			$msg = "";
			if(I('status',0)==0){
				$msg = "门票[".$goods[0]['goodsName']."]已被商城下架";
			}else{
				$msg = "门票[".$goods[0]['goodsName']."]已通过审核";
			}
			$yj_data = array(
				'msgType' => 0,
				'sendUserId' => session('WST_STAFF.staffId'),
				'receiveUserId' => $goods[0]['userId'],
				'msgContent' => $msg,
				'createTime' => date('Y-m-d H:i:s'),
				'msgStatus' => 0,
				'msgFlag' => 1,
			);
			M('messages')->add($yj_data);
			$rd['status'] = 1;
		}
		return $rd;
	 }
	 /**
	  * 获取待审核的门票数量
	  */
	 public function queryPenddingGoodsNum(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	$sql="select count(*) counts from __PREFIX__goods where goodsStatus=0 and goodsFlag=1";
	 	$rs = $this->query($sql);
	 	$rd['num'] = $rs[0]['counts'];
	 	return $rd;
	 }
	 /**
	  * 批量修改精品状态
	  */
	 public function changeBestStatus(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	$id = I('id',0);
	 	$m->isAdminBest = (int)I('status',0);
		$rs = $m->where('goodsId in('.$id.")")->save();
		if(false !== $rs){
			$rd['status'] = 1;
		}
		return $rd;
	 }
     /**
	  * 批量修改推荐状态
	  */
	 public function changeRecomStatus(){
	 	$rd = array('status'=>-1);
	 	$m = M('goods');
	 	$id = I('id',0);
	 	$m->isAdminRecom = (int)I('status',0);
		$rs = $m->where('goodsId in('.$id.")")->save();
		if(false !== $rs){
			$rd['status'] = 1;
		}
		return $rd;
	 }
	 /**
	 * 修改门票
	 */
	public function insert(){
	 	$rd = array('status'=>-1);
		$data = array();
		$data["goodsName"] = I("goodsName");
		$data["goodsImg"] = I("goodsImg");
		$data["goodsThums"] = I("goodsThumbs");
		$data["childPrice"] = (float)I("childPrice");
		$data["adultPrice"] = (float)I("adultPrice");
		$data["goodsStock"] = (int)I("goodsStock");
		$data["isBest"] = (int)I("isBest");
		$data["isRecomm"] = (int)I("isRecomm");
		$data["isNew"] = (int)I("isNew");
		$data["isHot"] = (int)I("isHot");
		$data["isSale"] = (int)I("isSale");
		$data["goodsCatId1"] = (int)I("goodsCatId1");
		$data["goodsCatId2"] = (int)I("goodsCatId2");
		$data["goodsCatId3"] = (int)I("goodsCatId3");
		$data["goodsDesc"] = I("goodsDesc",'',false);
		$data["goodsArea"] = I("goodsArea");
		$data["isIndexRecomm"] = 0;
		$data["isActivityRecomm"] = 0;
		$data["isInnerRecomm"] = 0;
		$data["goodsStatus"] = ($GLOBALS['CONFIG']['isGoodsVerify']==1)?0:1;
		$data["goodsFlag"] = 1;
		$data["createTime"] = date('Y-m-d H:i:s');
		$labelsIds = I("labelsIds");
		if($this->checkEmpty($data,true)){
			$data["goodsSpec"] = I("goodsSpec",'',false);
			$data["goodsKeywords"] = I("goodsKeywords",'',false);
			$m = M('goods');
			$goodsId = $m->add($data);
			if(false !== $goodsId){
				if($labelsIds!=''){
            $strway = explode(',',$labelsIds);
            foreach ($strway as $k => $v){
              $label['labelsId'] = $v;
              $label['goodsId'] = $goodsId;
              $m = M('goods_labels');
              $m->add($label);
              $rd['status']=1;
            }
          }
				//保存相册
				$gallery = I("gallery");
				if($gallery!=''){
					$str = explode(',',$gallery);
					foreach ($str as $k => $v){
						if($v=='')continue;
						$str1 = explode('@',$v);
						$data = array();
						$data['goodsId'] = $goodsId;
						$data['goodsImg'] = $str1[0];
						$data['goodsThumbs'] = $str1[1];
						$m = M('goods_gallerys');
						$m->add($data);
					}
				}
				$rd['status']=1;
			}
		}
		return $rd;
	}
	/**
	 * 新增门票
	 */
	public function edit(){
	 	$rd = array('status'=>-1);
		$data = array();
		$goodsId = (int)I("id",0);
		$data["goodsName"] = I("goodsName");
		$data["goodsImg"] = I("goodsImg");
		$data["goodsThums"] = I("goodsThumbs");
		$data["childPrice"] = (float)I("childPrice");
		$data["adultPrice"] = (float)I("adultPrice");
		$data["goodsStock"] = (int)I("goodsStock");
		$data["isBest"] = (int)I("isBest");
		$data["isRecomm"] = (int)I("isRecomm");
		$data["isNew"] = (int)I("isNew");
		$data["isHot"] = (int)I("isHot");
		$data["isSale"] = (int)I("isSale");
		$data["goodsCatId1"] = (int)I("goodsCatId1");
		$data["goodsCatId2"] = (int)I("goodsCatId2");
		$data["goodsCatId3"] = (int)I("goodsCatId3");
		$data["goodsDesc"] = I("goodsDesc",'',false);
		$data["goodsArea"] = I("goodsArea");
		$data["isIndexRecomm"] = 0;
		$data["isActivityRecomm"] = 0;
		$data["isInnerRecomm"] = 0;
		$data["goodsStatus"] = ($GLOBALS['CONFIG']['isGoodsVerify']==1)?0:1;
		$data["goodsFlag"] = 1;
		$data["createTime"] = date('Y-m-d H:i:s');
		$labelsIds = I("labelsIds");
		if($this->checkEmpty($data,true)){
			$data["goodsSpec"] = I("goodsSpec");
			$data["goodsKeywords"] = I("goodsKeywords");
			$m = M('goods');
			$rs = $m->where('goodsId='.$goodsId)->save($data);
			M('goods_gallerys')->where(array('goodsId' => $goodsId))->delete();
			if(false !== $rs){
				M('goods_labels')->where('goodsId='.$goodsId)->delete();
				if($labelsIds!=''){
            $strway = explode(',',$labelsIds);
            foreach ($strway as $k => $v){
              $label['labelsId'] = $v;
              $label['goodsId'] = $goodsId;
              $m = M('goods_labels');
              $m->add($label);
              $rd['status']=1;
            }
          }
				//保存相册
				$gallery = I("gallery");
				if($gallery!=''){
					$str = explode(',',$gallery);
					foreach ($str as $k => $v){
						if($v=='')continue;
						$str1 = explode('@',$v);
						$data = array();
						$data['goodsId'] = $goodsId;
						$data['goodsImg'] = $str1[0];
						$data['goodsThumbs'] = $str1[1];
						$m = M('goods_gallerys');
						$m->add($data);
						$rd['status']=1;
					}
				}
				$rd['status']=1;
			}
		}
		return $rd;
	}
};
?>