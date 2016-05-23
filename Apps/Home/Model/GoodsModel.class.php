<?php
namespace Home\Model;
/**
 * ============================================================================
 * 商品服务类
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
    $goodsLaSql = 'SELECT l.name FROM __PREFIX__goods_labels AS gl LEFT JOIN __PREFIX__labels AS l ON gl.labelsId = l.id WHERE gl.goodsId = '.I('goodsId');
    $data['labels'] = $this->query($goodsLaSql);
    return $data;
  }
}