<?php
 namespace Mobile\Model;
/**
 * ============================================================================
 * 文章服务类
 */
class ArticlesModel extends BaseModel {
    /**
   * 获取文章
   */
  public function getArticles(){
    $data['cat'] = M('article_cats')->where("catId=".(int)I('id'))->find();
    $data['articles'] = M('articles')->where("catId=".(int)I('id'))->select();
    return $data;
  }
  /**
   * 获取文章
   */
  public function getArticlesById(){
    $data = M('articles')->where("articleId=".(int)I('articleId'))->find();
    return $data;
  }

}
?>