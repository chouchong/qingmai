<?php
namespace Home\Model;
/**
 * ============================================================================
 * 自驾服务类
 */
class DrivesModel extends BaseModel {
	/**
	 * 自驾列表
	 */
	public function getDrivesList(){
    $m = M('drives');
    $pageSize = 1;
    $data = $m->field('drivesId,drivesDay,solaCount,pcDrivesImg,adultPrice,drivesDesc,drivesName,drivesFrom')->where('isSola=1')->order('drivesId desc')->limit($pageSize*I('page',0),$pageSize)->select();
    for ($i=0; $i < count($data); $i++) {
      $data[$i]['tp'] = M('drives_timeprice')->field('adultPrice')->where(array('drivesId' =>  $data[$i]['drivesId'],'daydata'=> date('Y-m-d', time() + (3 * 24 * 60 * 60))))->find();
    }
    return $data;
	}
    /**
    *自驾详情
    **/
    public function drivesDetail()
    {
      $m = M('drives');
      $data =  $m->where('drivesId='.I('drivesId'))->find();
      $data['tp'] = M('drives_timeprice')->where(array('drivesId' => I('drivesId'),'daydata'=> date('Y-m-d', time() + (3 * 24 * 60 * 60))))->find();
      $isWaySql = "SELECT h.hotelId,h.hotelDesc,h.hotelImg,h.hotelStar,h.hotelName from __PREFIX__drives_hotels AS dh RIGHT JOIN __PREFIX__hotel AS h on dh.hotelsId=h.hotelId WHERE dh.drivesId=".I('drivesId')." AND dh.isWay=1";
      $data['isWay'] = $this->query($isWaySql);
      $noWaySql = "SELECT h.hotelId,h.hotelDesc,h.hotelStar,h.hotelName,h.hotelImg,h.hotelType,h.hotelAddress from __PREFIX__drives_hotels AS dh RIGHT JOIN __PREFIX__hotel AS h on dh.hotelsId=h.hotelId WHERE dh.drivesId=".I('drivesId')." AND dh.isWay=0";
      $data['noWay'] = $this->query($noWaySql);
      for ($i=0; $i < count($data['noWay']); $i++) {
        $data['noWay'][$i]['gallerys'] = M('hotel_gallerys')->where('hid='.$data['noWay'][$i]['hotelId'])->limit(4)->select();
      }
      $atSQl = "SELECT a.articleTitle,a.articleContent FROM __PREFIX__drives_articles AS da RIGHT JOIN __PREFIX__articles AS a ON da.articlesId = a.articleId WHERE da.drivesId=".I('drivesId')." ORDER BY a.articleId ASC";
      $data['articles'] = $this->query($atSQl);
      $goodsSQl = "SELECT g.goodsId,g.goodsImg,g.goodsName,g.adultPrice,g.isRecomm,g.isBest,g.isNew FROM __PREFIX__drives_goods AS dg RIGHT JOIN __PREFIX__goods AS g on dg.goodsId = g.goodsId WHERE dg.drivesId = ".I('drivesId');
      $data['goods'] = $this->query($goodsSQl);
      for ($i=0; $i <count($data['goods']); $i++) {
        $goodsLaSql = 'SELECT l.name FROM __PREFIX__goods_labels AS gl LEFT JOIN __PREFIX__labels AS l ON gl.labelsId = l.id WHERE gl.goodsId = '.$data['goods'][$i]['goodsId'];
        $data['goods'][$i]['labels'] = $this->query($goodsLaSql);
      }
      return $data;
    }
    /**
    * 自驾评论
    **/
    public function getDap()
    {
      $pageSize = 6;
      $apSQL = "SELECT a.*,u.userName FROM __PREFIX__drives_appraises AS a LEFT JOIN __PREFIX__users AS u ON a.userId = u.userId WHERE a.drivesId = ".I('drivesId')." ORDER BY a.drivesScore LIMIT ".I('page',0)*$pageSize.",".$pageSize;
      $data['ap'] = $this->query($apSQL);
      $data['apcount'] = M('drives_appraises')->where(array('drivesId' => I('drivesId')))->count();
      return $data;
    }
}