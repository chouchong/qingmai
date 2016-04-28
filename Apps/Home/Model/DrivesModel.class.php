<?php
namespace Home\Model;
/**
 * ============================================================================
 * 商品服务类
 */
class DrivesModel extends BaseModel {
	/**
	 * 商品列表
	 */
	public function getDrivesList(){
    $m = M('drives');
    $data = $m->field('drivesId,drivesDay,solaCount,pcDrivesImg,adultPrice,drivesDesc')->where('isSola=1')->order('drivesId desc')->limit(3)->select();
    for ($i=0; $i < count($data); $i++) {
      $data[$i]['tp'] = M('drives_timeprice')->field('adultPrice')->where(array('drivesId' =>  $data[$i]['drivesId'],'daydata'=> date('Y-m-d', time() + (10 * 24 * 60 * 60))))->find();
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
      $data['tp'] = M('drives_timeprice')->where(array('drivesId' => I('drivesId'),'daydata'=> date('Y-m-d', time() + (10 * 24 * 60 * 60))))->find();
      $isWaySql = "SELECT h.hotelId,h.hotelDesc,h.hotelImg from __PREFIX__drives_hotels AS dh RIGHT JOIN __PREFIX__hotel AS h on dh.hotelsId=h.hotelId WHERE dh.drivesId=".I('drivesId')." AND dh.isWay=1";
      $data['isWay'] = $this->query($isWaySql);
      $noWaySql = "SELECT h.hotelId,h.hotelDesc,h.hotelStar,h.hotelName from __PREFIX__drives_hotels AS dh RIGHT JOIN __PREFIX__hotel AS h on dh.hotelsId=h.hotelId WHERE dh.drivesId=".I('drivesId')." AND dh.isWay=0";
      $data['noWay'] = $this->query($noWaySql);
      for ($i=0; $i < count($data['noWay']); $i++) {
        $data['noWay'][$i]['gallerys'] = M('hotel_gallerys')->where('hid='.$data['noWay'][$i]['hotelId'])->limit(4)->select();
      }
      $atSQl = "SELECT a.articleTitle,a.articleContent FROM __PREFIX__drives_articles AS da RIGHT JOIN __PREFIX__articles AS a ON da.articlesId = a.articleId WHERE da.drivesId=".I('drivesId')." ORDER BY a.articleId ASC";
      $data['articles'] = $this->query($atSQl);
      $goodsSQl = "SELECT g.goodsId,g.goodsImg,g.goodsName,g.adultPrice,g.isRecomm,g.isBest,g.isNew FROM __PREFIX__drives_goods AS dg RIGHT JOIN __PREFIX__goods AS g on dg.goodsId = g.goodsId WHERE dg.drivesId = ".I('drivesId');
      $data['goods'] = $this->query($goodsSQl);
      $apSQL = "SELECT a.*,u.userName FROM __PREFIX__drives_appraises AS a LEFT JOIN __PREFIX__users AS u ON a.userId = u.userId WHERE a.drivesId = ".I('drivesId')." ORDER BY a.drivesScore LIMIT 3";
      $data['ap'] = $this->query($apSQL);
      $data['apcount'] = M('drives_appraises')->where(array('drivesId' => I('drivesId')))->count();
      return $data;
    }
}