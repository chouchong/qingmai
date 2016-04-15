<?php
 namespace Admin\Model;
/**
 * ============================================================================
 * 门票属性类
 */
class GoodsAttributesModel extends BaseModel {
  //门票属性添加
  public function insert(){
    $rd = array('status'=>-1);
    $data = array();
    $data["goodsId"] = I("goodsId");
    $data["attrId"] = I("attrId");
    $data["attrVal"] = I("attrVal");
    $data["attrPrice"] = I("attrPrice",0.0);
    // $data["attrStock"] = I("attrStock",0);
    if($this->checkEmpty($data,true)){
      $data["attrDesc"] = I("attrDesc",'','htmlspecialchars');
      $m = M('goods_attributes');
      $goodsId = $m->add($data);
      if(false !== $goodsId){
        $rd['status']=1;
      }
    }
    return $rd;
  }
  //获取门票属性
  public function findGoodsAttr(){
    $data = array();
    $data = M('goods_attributes')->where(array('goodsId' =>I('goodsId'),'attrId'=>I('attrId')))->select();
    return $data;
  }
  //删除门票属性
  public function delAttr(){
    $rd = array('status'=>-1);
    $data = array();
    $goodsId = M('goods_attributes')->where(array('id' =>I('id'),'attrId'=>I('attrId')))->delete();
    if(false !== $goodsId){
        $rd['status']=1;
      }
    return $rd;
  }
};
?>