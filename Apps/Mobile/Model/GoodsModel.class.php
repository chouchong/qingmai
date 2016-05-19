<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 门票服务类
 */
class GoodsModel extends BaseModel {
  /**
   * 获取门票详情
   */
  public function goodsDetail(){
    $m = M('goods');
    $data = $m->where(array('goodsId' => I('goodsId')))->find();
    $data['attrPrice'] = M('goods_attributes')->field('attrVal,attrPrice')->where(array('goodsId' => I('goodsId'),'attrId'=>1))->select();
    $data['attrfd'] = M('goods_attributes')->field('attrVal')->where(array('goodsId' => I('goodsId'),'attrId'=>2))->select();
    return $data;
  }
  /**
   * 获取门票是哪个自驾推荐
   */
  public function goodsFindDrivesId(){
    $m = M('drives_goods');
    $data = $m->field('drivesId')->where(array('goodsId' => I('goodsId')))->find();
    return $data;
  }
}
?>