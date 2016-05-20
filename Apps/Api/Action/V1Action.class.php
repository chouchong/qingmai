<?php
namespace Api\Action;
/**
 * ============================================================================
 * Api控制器
 */
use Think\Controller;
class V1Action extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }
  //文章分类
  public function getCategory()
  {
    $object  = D('Home/Articles')->getCategory();
    echo json_encode($object);
    die();
  }
  //首页的自驾列表
  public function getDList()
  {
  	$object  = D('Home/Drives')->getDrivesList();
  	echo json_encode($object);
    die();
  }
  // 自驾游评论
  public function getApList()
  {
    $object  = D('Home/Drives')->getDap();
    echo json_encode($object);
    die();
  }
}