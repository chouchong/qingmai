<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 自驾服务类
 */
class DrivesModel extends BaseModel {
     /**
	  * 查询登录关键字
	  */
    public function insert(){
      $rd = array('status'=>-1);
      $data = array();
      $data["drivesName"] = I("drivesName");
      $data["drivesFrom"] = I("drivesFrom");
      $data["childPrice"] = (int)I("childPrice");
      $data["adultPrice"] = (int)I("adultPrice");
      $data["drivesDay"] = (int)I("drivesDay");
      $data["homePrice"] = (int)I("homePrice");
      $data["drivesImg"] = I("drivesImg");
      $data["drivesMap"] = I("drivesMap");
      $data["createTime"] = date('Y-m-d H:i:s');
      if($this->checkEmpty($data,true)){
        $data["drivesSpec"] = I("drivesSpec",'',false);
        $data["drivesKeywords"] = I("drivesKeywords",'',false);
        $data["priceDesc"] = I("priceDesc",'',false);
        $data["isFeeDesc"] = I("isFeeDesc",'',false);
        $data["noFeeDesc"] = I("noFeeDesc",'',false);
        $data["presentProject"] = I("presentProject",'',false);
        $data["drivesDesc"] = I("drivesDesc",'',false);
        $Hotel = I("zhuchuHotels");
        $way = I("tuzhongHotels");
        $goodsids = I("goodsids");
        $articlesIds = I("articlesIds");
        $m = M('drives');
        $drivesId = $m->add($data);
        if(false !== $drivesId){
          if($Hotel!=''){
            $strHotel = explode(',',$Hotel);
            foreach ($strHotel as $k => $v){
              $Hotels['hotelsId'] = $v;
              $Hotels['drivesId'] = $drivesId;
              $Hotels['isWay'] = 0;
              $m = M('drives_hotels');
              $m->add($Hotels);
              $rd['status']=1;
            }
          }
          if($way!=''){
            $strway = explode(',',$way);
            foreach ($strway as $k => $v){
              $wayHotel['hotelsId'] = $v;
              $wayHotel['drivesId'] = $drivesId;
              $wayHotel['isWay'] = 1;
              $m = M('drives_hotels');
              $m->add($wayHotel);
              $rd['status']=1;
            }
          }
          if($goodsids!=''){
            $strgood = explode(',',$goodsids);
            foreach ($strgood as $k => $v){
              $goods['goodsId'] = $v;
              $goods['drivesId'] = $drivesId;
              $m = M('drives_goods');
              $m->add($goods);
              $rd['status']=1;
            }
          }
          if($articlesIds!=''){
           $m = M('articles');
          $rs = $m->field('articleId')->where(array('catId'=>$articlesIds))->order('articleId asc')->select();
          foreach ($rs as $v){
            $articles['articlesId'] = $v['articleId'];
            $articles['drivesId'] = $drivesId;
            $m = M('drives_articles');
            $m->add($articles);
          }
          }
        }
      }
      return $rd;
    }
    //
    public function edit(){
      $rd = array('status'=>-1);
      $data = array();
      $drivesId = I('id');
      $data["drivesName"] = I("drivesName");
      $data["drivesFrom"] = I("drivesFrom");
      $data["childPrice"] = (int)I("childPrice");
      $data["adultPrice"] = (int)I("adultPrice");
      $data["drivesDay"] = (int)I("drivesDay");
      $data["homePrice"] = (int)I("homePrice");
      $data["drivesImg"] = I("drivesImg");
      $data["drivesMap"] = I("drivesMap");
      $data["createTime"] = date('Y-m-d H:i:s');
      if($this->checkEmpty($data,true)){
        $data["drivesSpec"] = I("drivesSpec",'',false);
        $data["drivesKeywords"] = I("drivesKeywords",'',false);
        $data["priceDesc"] = I("priceDesc",'',false);
        $data["isFeeDesc"] = I("isFeeDesc",'',false);
        $data["noFeeDesc"] = I("noFeeDesc",'',false);
        $data["drivesDesc"] = I("drivesDesc",'',false);
        $data["presentProject"] = I("presentProject",'',false);
        $Hotel = I("zhuchuHotels");
        $way = I("tuzhongHotels");
        $goodsids = I("goodsids");
        $articlesIds = I("articlesIds");
        $m = M('drives');
        $rs = $m->where('drivesId='.$drivesId)->save($data);
        if(false !== $rs){
          M('drives_hotels')->where('drivesId='.$drivesId)->delete();
          M('drives_goods')->where('drivesId='.$drivesId)->delete();
          M('drives_articles')->where('drivesId='.$drivesId)->delete();
          if($Hotel!=''){
            $strHotel = explode(',',$Hotel);
            foreach ($strHotel as $k => $v){
              $Hotels['hotelsId'] = $v;
              $Hotels['drivesId'] = $drivesId;
              $Hotels['isWay'] = 0;
              $m = M('drives_hotels');
              $m->add($Hotels);
              $rd['status']=1;
            }
          }
          if($way!=''){
            $strway = explode(',',$way);
            foreach ($strway as $k => $v){
              $wayHotel['hotelsId'] = $v;
              $wayHotel['drivesId'] = $drivesId;
              $wayHotel['isWay'] = 1;
              $m = M('drives_hotels');
              $m->add($wayHotel);
              $rd['status']=1;
            }
          }
          if($goodsids!=''){
            $strgood = explode(',',$goodsids);
            foreach ($strgood as $k => $v){
              $goods['goodsId'] = $v;
              $goods['drivesId'] = $drivesId;
              $m = M('drives_goods');
              $m->add($goods);
              $rd['status']=1;
            }
          }
          if($articlesIds!=''){
            $m = M('articles');
            $rs = $m->field('articleId')->where(array('catId'=>$articlesIds))->order('articleId asc')->select();
            foreach ($rs as $v){
              $articles['articlesId'] = $v['articleId'];
              $articles['drivesId'] = $drivesId;
              $m = M('drives_articles');
              $m->add($articles);
            }
          }
        }
      }
      return $rd;
    }
    /**
    * 分页列表[获取已审核列表]
    */
    public function queryByPage(){
      $m = M('drives');
        $sql = "select drivesId,drivesName,drivesDay FROM __PREFIX__drives where isSola=1 order by drivesId desc";
      return $m->pageQuery($sql);
   }
   /**
    *自驾ById
    */
    public function queryById(){
      $m = M('drives');
      $drives = $m->where(array('drivesId'=>I('drivesId')))->find();
      $driveshotelsIds = array();
      $vaHotels = M('drives_hotels')->where(array('drivesId'=>I('drivesId'),'isWay'=>0))->select();
      for ($i=0; $i <count($vaHotels); $i++) {
        $driveshotelsIds[]=$vaHotels[$i]['hotelsId'];
      }
      $drives['driveshotelsIds']=implode(",", $driveshotelsIds);
      $driveswayhotelsIds = array();
      $wayHotels= M('drives_hotels')->where(array('drivesId'=>I('drivesId'),'isWay'=>1))->select();
      for ($i=0; $i <count($wayHotels); $i++) {
        $driveswayhotelsIds[]=$wayHotels[$i]['hotelsId'];
      }
      $drives['driveswayhotelsIds']=implode(",", $driveswayhotelsIds);
      $drivesgoodsIds = array();
      $drivesgoods = M('drives_goods')->where(array('drivesId'=>I('drivesId')))->select();
      for ($i=0; $i <count($drivesgoods); $i++) {
        $drivesgoodsIds[]=$drivesgoods[$i]['goodsId'];
      }
      $drives['drivesgoodsIds']=implode(",", $drivesgoodsIds);
      $drivesarticlesIds = array();
      $drivesarticles = M('drives_articles')->where(array('drivesId'=>I('drivesId')))->select();
      for ($i=0; $i <count($drivesarticles); $i++) {
        $drivesarticlesIds[]=$drivesarticles[$i]['articlesId'];
      }
      $drives['drivesarticlesIds']=implode(",", $drivesarticlesIds);
      return $drives;
   }
   /**
   *时间价格添加
   **/
    public function addTimePrice(){
      $m = M('drives');
      $rd = array('status'=>-1);
      $data = array();
      $data["drivesId"] = I("drivesId");
      $data["drivesStock"] = I("drivesStock");
      $data["adultPrice"] = (int)I("adultPrice");
      $data["daydata"] = I("daydata");
      if($this->checkEmpty($data,true)){
          $data["drivesType"] = I("drivesType");
          $data["timeDesc"] = I("timeDesc",'',false);
          $m = M('drives_timeprice');
          $id = $m->add($data);
          if($id>0){
            $rd['status'] = 1;
          }
      }else{
        $rd['msg'] = '数据填写不完整';
      }
      return $rd;
    }
      /**
    *查询时间价格
    **/
    public function timePrice(){
      $rs = array();
      $m = M('drives_timeprice');
      $rs = $m->field('timeId,drivesStock,daydata,adultPrice')->where('drivesId='.I('drivesId'))->select();
      return $rs;
    }
    /**
    *删除
    **/
    public function deltimePrice(){
      $rd = array('status'=>-1);
      $m = M('drives_timeprice');
      $rs = $m->where('timeId='.I('timeId'))->delete();
      if($rs){
        $rd['status'] = 1;
      }
      return $rd;
    }
       /**
    *自驾禁用
    **/
    public function changeDrives(){
      $rd = array('status'=>-1);
      $rs = array();
      $m = D('Admin/Drives');
      $data['isSola'] = I('isSola');
      $rs = $m->where('drivesId='.I('drivesId'))->save($data);
      if($rs){
        $rd['status'] = 1;
      };
      return $rd;
    }
  };
?>