<?php
 namespace Mobile\Action;
/**
 * ============================================================================
 * 文章控制器
 */
class ArticlesAction extends BaseAction{
	/**
	 * 查询
	 */
	public function index(){
    $this->data = D('Mobile/Articles')->getArticles();
    $this->display("/tpl/articles");
	}
  /**
   * 查询文章
   */
  public function getArticle(){
    $data = D('Mobile/Articles')->getArticlesById();
    $this->ajaxReturn($data);
  }
};
?>