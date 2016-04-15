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
    $data = $m->where(array('goodsId' => I('goodsId',6)))->find();
    $data['attrPrice'] = M('goods_attributes')->field('attrVal,attrPrice')->where(array('goodsId' => I('goodsId',6),'attrId'=>1))->select();
    $data['attrfd'] = M('goods_attributes')->field('attrVal')->where(array('goodsId' => I('goodsId',6),'attrId'=>2))->select();
    return $data;
  }
}
?>