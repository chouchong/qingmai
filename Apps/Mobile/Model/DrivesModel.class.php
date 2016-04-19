<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 自驾服务类
 */
class DrivesModel extends BaseModel {
    private $daytime;
    /**
    * 查询
    */
    public function pageByIndex()
    {
      $m = M('drives');
      $data = $m->field('drivesId,drivesImg,adultPrice,drivesDesc')->where('isSola=1')->order('drivesId desc')->limit(3)->select();
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
    /**
    *获取自驾某些
    **/
    public function getDrivesfield()
    {
      $m = M('drives');
      $data =  $m->field('drivesId,drivesImg,drivesName,drivesFrom,drivesDay,childPrice,homePrice')->where('drivesId='.I('drivesId'))->find();
      return $data;
    }
    /**
    *自驾价格时间
    **/
    public function drivesTimePrices()
    {
      $map['daydata'] = array('EGT',date('Y-m-d', time()));
      $map['drivesId'] = I('drivesId');
      return M('drives_timeprice')->field('timeId,drivesStock,adultPrice,daydata')->where($map)->order('daydata asc')->select();
    }
    /**
    *价格详情
    **/
    public function getTp()
    {
      return M('drives_timeprice')->where(array('timeId' => I('timeId')))->find();
    }
    /**
    *自驾添加评论
    **/
    public function addComment()
    {
      $rd = array('status' => -1);
      $did = M('order_goods')->field('drivesId')->where(array('orderId'=>I('orderId')))->find();
      $data['drivesId'] = $did['drivesId'];
      $data['userId'] = session('Users')['userId'];
      $data['drivesScore'] = I('drivesScore');
      $data['content'] = I('conT');
      $data['orderNo'] = I('orderNo');
      $data["createTime"] = date('Y-m-d H:i:s');
      $data['isShow'] = 1;
      $rs = M('drives_appraises')->add($data);
      if($rs !== false){
        M('orders')->where(array('orderId'=>I('orderId')))->save(array('orderStatus' =>3));
        $rd['status'] = 1;
      }
      return $rd;
    }
}
?>