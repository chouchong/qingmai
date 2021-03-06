<?php
namespace Home\Action;
/**
 * ============================================================================
 * 文章制器
 */
class ArticlesAction extends BaseAction {
 /**
  *获取文章内容
  **/
  public function getContent()
  {
    $this->content = D('Home/Articles')->getArticlesContent();
    $this->display('tpl/content');
  }
  /**
   * 查询文章
   */
  public function getArticle(){
    $data = D('Home/Articles')->getArticlesById();
    $this->ajaxReturn($data);
  }
}