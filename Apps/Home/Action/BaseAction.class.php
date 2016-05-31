<?php
namespace Home\Action;
/**
 * ============================================================================
 * 基础控制器
 */
use Think\Controller;
class BaseAction extends Controller {
	public function __construct(){
		parent::__construct();
		if(WSTIsMobile()){
	      $this->redirect("Mobile/Index/index");
	    }
		$this->foot=D('Home/Articles')->getArticles();
		$this->userSession=session('Users');
    	$this->CONF = D('Mobile/System')->loadConfigs();
	}
	/**
	 * 生成URL
	 */
	public function getURL(){
		$params = I('post.');
		$wstModel = $params["wstModel"];
		$wstControl = $params["wstControl"];
		$wstAction = $params["wstAction"];
		$newparams = array();
		$baseParas = array("wstModel","wstControl","wstAction");
		foreach ($params as $key => $p) {
			if(!in_array($key, $baseParas) ){
				$newparams[$key] = $p;
			}
		}
		$data["url"] = U($wstModel.'/'.$wstControl.'/'.$wstAction,$newparams);
		return $this->ajaxReturn($data);

	}
    /**
	 * 单个上传图片
	 */
    public function uploadPic(){
	   $config = array(
		        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
		        'exts'          =>  array('jpg','png','gif','jpeg'), //允许上传的文件后缀
		        'rootPath'      =>  './Upload/', //保存根路径
		        'driver'        =>  'LOCAL', // 文件上传驱动
		        'subName'       =>  array('date', 'Y-m'),
		        'savePath'      =>  I('dir','uploads')."/"
		);
	    $folder = I("folder");
		$upload = new \Think\Upload($config);
		$rs = $upload->upload($_FILES);
		$Filedata = key($_FILES);
		if(!$rs){
			$this->error($upload->getError());
		}else{
			$images = new \Think\Image();
			$images->open('./Upload/'.$rs[$Filedata]['savepath'].$rs[$Filedata]['savename']);
			$newsavename = str_replace('.','_thumb.',$rs[$Filedata]['savename']);
			$vv = $images->thumb(I('width',300), I('height',300))->save('./Upload/'.$rs[$Filedata]['savepath'].$newsavename);
		    if(C('WST_M_IMG_SUFFIX')!=''){
		        $msuffix = C('WST_M_IMG_SUFFIX');
		        $mnewsavename = str_replace('.',$msuffix.'.',$rs[$Filedata]['savename']);
		        $mnewsavename_thmb = str_replace('.',"_thumb".$msuffix.'.',$rs[$Filedata]['savename']);
			    $images->open('./Upload/'.$rs[$Filedata]['savepath'].$rs[$Filedata]['savename']);
			    $images->thumb(I('width',700), I('height',700))->save('./Upload/'.$rs[$Filedata]['savepath'].$mnewsavename);
			    $images->thumb(I('width',250), I('height',250))->save('./Upload/'.$rs[$Filedata]['savepath'].$mnewsavename_thmb);
			}
			$rs[$Filedata]['savepath'] = "Upload/".$rs[$Filedata]['savepath'];
			$rs[$Filedata]['savethumbname'] = $newsavename;
			$rs['status'] = 1;
			if($folder=="Filedata"){
				$sfilename = I("sfilename");
				$fname = I("fname");
				$srcpath = $rs[$Filedata]['savepath'].$rs[$Filedata]['savename'];
				$thumbpath = $rs[$Filedata]['savepath'].$rs[$Filedata]['savethumbname'];
				echo "<script>parent.getUploadFilename('$sfilename','$srcpath','$thumbpath','$fname');</script>";
			}else{
				echo json_encode($rs);
			}
		}
    }
      /**
	 * 多个上传图片
	 */
    public function uploadPics(){
	   $config = array(
		        'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
		        'exts'          =>  array('jpg','png','gif','jpeg'), //允许上传的文件后缀
		        'rootPath'      =>  './Upload/', //保存根路径
		        'driver'        =>  'LOCAL', // 文件上传驱动
		        'subName'       =>  array('date', 'Y-m'),
		        'savePath'      =>  'carLicense/'
		);
		$upload = new \Think\Upload($config);
		$rs = $upload->upload($_FILES);
		$sfilename=$rs['Filedata']['savename'];
		$srcpath=$rs['Filedata']['savepath'];
        $len=I('len');
        $type=I('type');
		if ($rs) {
			echo "<script>parent.getUploadFilenames('$sfilename','$srcpath','$len','$type');</script>";
		}
		else{
			$this->error($upload->getError());
		}
	}
	/**
   * 登录操作验证
   */
  public function isLogin(){
    $s = session('Users');
      if(empty($s))$this->redirect("Users/gologin");
  }
  /**
   * 登录操作验证
   */
  public function getLogin(){
    $s = session('Users');
    $rs['status'] = !empty($s)?1:-1;
    echo json_encode($rs);
  }
  /*
  商城信息
  */
  public function Config(){
   	$m = D('Mobile/System');
    $Config = $m->loadConfigs();
    echo json_encode($Config);
  }
}