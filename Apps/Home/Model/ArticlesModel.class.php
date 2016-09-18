<?php
namespace Home\Model;
class ArticlesModel extends BaseModel {
	/**
	 * foot数据
	 */
	public function getArticles(){
   $m = M('article_cats');
   $result['art'] = $m->Field(array('catId','catName'))->where(array('isShow'=>1))->limit(4)->select();
   for($i=0;$i<count($result['art']);$i++){
     $result['art'][$i]['articles']=M('articles')->field('articleId,articleTitle')->where(array('catId'=>$result['art'][$i]['catId']))->limit(4)->select();
   }
   $result['footer']=M('sys_configs')->field('fieldValue')->where(array('fieldName'=>'底部设置'))->find();
   return $result; 
  }
  //分类下的文章
  public function getArticlesContent(){
    $sql="select dt_articles.articleTitle,dt_articles.articleContent,dt_article_cats.catName from dt_article_cats left join dt_articles on dt_articles.catId=dt_article_cats.catId where dt_articles.catId=".I('catId');
    $result = $this->query($sql);
    return $result;
  }
  //文章pc端分类
  public function getCategory(){
   $m = M('article_cats');
   $result = $m->Field(array('catId','catName'))->where(array('isShow'=>1))->limit(4)->select();
   for($i=0;$i<count($result);$i++){
     $result[$i]['articles']=M('articles')->field('articleId,articleTitle')->where(array('catId'=>$result[$i]['catId']))->limit(4)->select();
   }
   return $result;
  }
  /**
   * 获取文章
   */
  public function getArticlesById(){
    $data = M('articles')->where("articleId=".(int)I('articleId'))->find();
    return $data;
  }
}